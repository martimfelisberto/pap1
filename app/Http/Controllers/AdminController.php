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
    public function users()
    {
        // Change from Collection to Paginator
        $users = User::query()
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Will show 10 users per page

        return view('admin.users.index', compact('users'));
    }
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        
        $stats = [
            'users' => User::count(),
            'produtos' => Produto::count() ?? 0,
            'categorias' => Categoria::count() ?? 0,
        ];
        
        return view('dashboard', compact('stats'));
    }
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
                return $query->where('produtos', 'like', "%{$search}%")
                             ->orWhere('categoria', 'like', "%{$search}%");
            })->paginate(10);
        
        $categorias = Categoria::when($search, function($query) use ($search) {
            return $query->where('nome', 'like', "%{$search}%");
        })->paginate(10);
        
        return view('dashboard', compact('users', 'produtos', 'categorias', 'search'));
    }
    
    
    /**
     * Ban/unban a user
     */
    
    
    /**
     * Delete a recipe
     */
    public function deleteProduto(Produto $produto)
    {
        $this->checkAdmin();
        
        // Delete the recipe image if exists
        if ($produto->produto_foto && file_exists(storage_path('app/public/' . $produto->produto_foto))) {
            unlink(storage_path('app/public/' . $produto->produto_foto));
        }
        
        $produto->delete();
        return redirect()->route('dashboard')->with('success', 'Produto eliminada com sucesso!');
    }

    /**
     * Show the form for creating a new category
     */
    public function createCategoria()
    {
        $this->checkAdmin();
        return view('categorias.create');
    }

    /**
     * Store a newly created category
     */
    public function storeCategoria(Request $request)
    {
        $this->checkAdmin();
        
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:categorias',
            'genero' => 'required|in:homem,mulher,criança'
        ]);
        
        Categoria::create($validated);
        
        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Show the form for editing a user
     */
    public function editUser(User $user)
    {
        $this->checkAdmin();
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function updateUser(Request $request, User $user)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'boolean'
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilizador atualizado com sucesso.');
    }
    
    /**
     * Remove a user from the system
     */
    public function destroy(User $user)
    {
        $this->checkAdmin();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Não pode eliminar o seu próprio utilizador.');
        }

        try {
            $user->delete();
            return back()->with('success', 'Utilizador eliminado com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Erro ao eliminar utilizador: ' . $e->getMessage());
            return back()->with('error', 'Erro ao eliminar utilizador.');
        }
    }
}
