<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    /**
     * Constructor to check admin access
     */
    public function __construct()
    {
        // Don't use middleware() here - it's causing the error
        // Instead, we'll check admin status directly in each method
    }
    
    /**
     * Check if the current user is an admin
     */
    private function checkAdmin()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Acesso não autorizado.');
        }
    }
    
    /**
     * Display admin dashboard
     */
    public function index(Request $request)
    {
        $this->checkAdmin();
        
        $search = $request->input('search');
        
        $users = User::when($search, function($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);
        
        $produtos = Produto::with('user')
            ->when($search, function($query) use ($search) {
                return $query->where('produto_titulo', 'like', "%{$search}%")
                             ->orWhere('categoria', 'like', "%{$search}%")
                             ->orWhere('estado', 'like', "%{$search}%")
                             ->orWhere('preco', 'like', "%{$search}%");
            })->paginate(10);
        
        $categorias = Categoria::when($search, function($query) use ($search) {
            return $query->where('nome', 'like', "%{$search}%");
        })->paginate(10);
        
        return view('admin.dashboard', compact('users', 'produtos', 'categorias', 'search'));
    }
    
    /**
     * Ban/unban a user
     */
    public function toggleUserBan(Request $request, User $user)
    {
        $this->checkAdmin();
        
        $user->is_banned = !$user->is_banned;
        $user->save();
        
        $status = $user->is_banned ? 'banido' : 'desbanido';
        return redirect()->route('admin.dashboard')->with('success', "Utilizador {$status} com sucesso!");
    }
    
    /**
     * Delete a product
     */
    public function deleteProduto(Produto $produto)
    {
        $this->checkAdmin();
        
        // Delete the product images if they exist
        if ($produto->produto_fotos) {
            $fotos = json_decode($produto->produto_fotos);
            foreach ($fotos as $foto) {
                if (file_exists(storage_path('app/public/' . $foto))) {
                    unlink(storage_path('app/public/' . $foto));
                }
            }
        }
        
        $produto->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Produto eliminado com sucesso!');
    }

    /**
     * Display a list of users
     */
    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing a user
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update a user's information
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'boolean'
        ]);

        $user->update($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilizador atualizado com sucesso.');
    }
}
