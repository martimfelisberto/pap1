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
        if ($produto->receita_foto && file_exists(storage_path('app/public/' . $produto->receita_foto))) {
            unlink(storage_path('app/public/' . $produto->receita_foto));
        }
        
        $produto->delete();
        return redirect()->route('dashboard')->with('success', 'Produto eliminada com sucesso!');
    }
}
