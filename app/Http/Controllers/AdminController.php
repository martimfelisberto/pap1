<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;	
use Illuminate\Support\Facades\Storage;

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

        $users = User::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        $produtos = Produto::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->where('produtos', 'like', "%{$search}%")
                    ->orWhere('categoria', 'like', "%{$search}%");
            })->paginate(10);

        $categorias = Categoria::when($search, function ($query) use ($search) {
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
            'genero' => 'required|string|max:50',
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
     * Remove a user from the system bypassing relationship checks
     */
    public function destroyUser($id)
    {
        try {
            // Verificação de admin
            $this->checkAdmin();
            
            // Verificar se não está tentando excluir a si mesmo
            if ($id == Auth::id()) {
                return back()->with('error', 'Não pode eliminar o seu próprio utilizador.');
            }
            
            // Usar transação para garantir consistência
            DB::beginTransaction();
            
            // Primeiro, verificamos se o usuário existe
            $user = DB::table('users')->where('id', $id)->first();
            
            if (!$user) {
                return back()->with('error', 'Utilizador não encontrado.');
            }
            
            // 1. Remover produtos associados ao usuário (ou torná-los sem dono)
            DB::table('produtos')->where('user_id', $id)->update(['user_id' => null]);
            
            // 2. Remover favoritos se existirem
            if (Schema::hasTable('favorites')) {
                DB::table('favorites')->where('user_id', $id)->delete();
            }
            
            // 3. Finalmente, excluir o usuário diretamente pelo ID
            DB::table('users')->where('id', $id)->delete();
            
            DB::commit();
            
            return redirect()->route('admin.users.index')
                ->with('success', 'Utilizador eliminado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir usuário: ' . $e->getMessage());
            return back()->with('error', 'Erro ao excluir usuário: ' . $e->getMessage());
        }
    }

    public function gerirProdutos()
    {
        $produtos = \App\Models\Produto::with(['user', 'categoria'])->latest()->paginate(20);
        return view('admin.produtos.index', compact('produtos'));
    }
}