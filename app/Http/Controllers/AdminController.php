<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\CategoryType;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Constructor to check admin access
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
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
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Produto::count(),
            'total_categories' => Categoria::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // Product Management
    /**
     * Display a list of products
     */
    public function products()
    {
        $products = Produto::with(['user', 'categoria'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for editing a product
     */
    public function editProduct(Produto $produto)
    {
        $categories = Categoria::all();
        return view('admin.products.edit', compact('produto', 'categories'));
    }

    /**
     * Update a product's information
     */
    public function updateProduct(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'estado' => 'required|in:novo,usado,semi-novo',
            'imagem' => 'sometimes|image|max:2048'
        ]);

        if ($request->hasFile('imagem')) {
            // Delete old image
            if ($produto->imagem) {
                Storage::delete('public/' . $produto->imagem);
            }
            // Store new image
            $validated['imagem'] = $request->file('imagem')->store('produtos', 'public');
        }

        $produto->update($validated);

        return redirect()->route('admin.products')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Delete a product
     */
    public function deleteProduct(Produto $produto)
    {
        if ($produto->imagem) {
            Storage::delete('public/' . $produto->imagem);
        }
        
        $produto->delete();
        return redirect()->route('admin.products')
            ->with('success', 'Produto eliminado com sucesso.');
    }

    // Category Management
    /**
     * Display a list of categories
     */
    public function categories()
    {
        $categories = Categoria::withCount('produtos')
            ->orderBy('nome')
            ->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a category
     */
    public function createCategory()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a new category
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:categorias',
            'genero' => 'required|in:homem,mulher,crianca,unissex'
        ]);

        Categoria::create($validated);

        return redirect()->route('admin.categories')
            ->with('success', 'Categoria criada com sucesso.');
    }

    /**
     * Show the form for editing a category
     */
    public function editCategory(Categoria $categoria)
    {
        return view('admin.categories.edit', compact('categoria'));
    }

    /**
     * Update a category's information
     */
    public function updateCategory(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:categorias,nome,' . $categoria->id,
            'genero' => 'required|in:homem,mulher,crianca,unissex'
        ]);

        $categoria->update($validated);

        return redirect()->route('admin.categories')
            ->with('success', 'Categoria atualizada com sucesso.');
    }

    /**
     * Delete a category
     */
    public function deleteCategory(Categoria $categoria)
    {
        // Check if category has products
        if ($categoria->produtos()->exists()) {
            return redirect()->route('admin.categories')
                ->with('error', 'Não é possível eliminar uma categoria com produtos associados.');
        }

        $categoria->delete();
        return redirect()->route('admin.categories')
            ->with('success', 'Categoria eliminada com sucesso.');
    }

    public function indexCategorias()
    {
        $categorias = Categoria::orderBy('nome')->paginate(10);
        return view('admin.categorias.index', compact('categorias'));
    }

    public function createCategoria()
    {
        return view('admin.categorias.create');
    }

    public function storeCategoria(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:categorias',
            'genero' => 'required|in:homem,mulher,crianca,unissex'
        ]);

        Categoria::create($validated);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    // User Management
    /**
     * Display a list of users
     */
    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
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
