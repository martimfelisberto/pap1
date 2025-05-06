<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produto;
use App\Models\Categorias;
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
        
        $categorias = Categorias::when($search, function($query) use ($search) {
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
}
