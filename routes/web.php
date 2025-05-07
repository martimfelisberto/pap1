<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Models\Produto;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;


// Rotas públicas
Route::get('/', function () {
    return view('welcome');
});
// Rotas que requerem autenticação
Route::middleware(['auth'])->group(function () {
    // Rotas para todos os usuários autenticados
    Route::get('/produtos/criar', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/meus-produtos', [ProdutoController::class, 'userProducts'])->name('produtos.user');
});

// Rotas administrativas
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('categorias', CategoriaController::class)->except(['index', 'show']);
    Route::get('/produtos', [AdminController::class, 'produtos'])->name('produtos.index');
    Route::patch('/users/{user}/toggle-ban', [AdminController::class, 'toggleUserBan'])->name('users.toggle-ban');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
    
Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::get('/profile/produtos', [ProfileController::class, 'produtos'])->name('profile.products');
    Route::get('/profile/vendas', [ProfileController::class, 'vendas'])->name('profile.sales');
});

Route::get('/contactos', function () {
    return view('contactos');
});

Route::delete('/admin/produtos/{produto}', 'Admin\ProductController@destroy')->name('admin.produtos.delete');

// Rotas de Produtos
Route::prefix('produtos')->name('produtos.')->group(function () {
    // Rotas públicas
    Route::get('/', [ProdutoController::class, 'index'])->name('index');
    Route::get('/{categoria}/{genero}', [ProdutoController::class, 'categoria'])
        ->name('categoria')
        ->where('categoria', 'casacos|tshirts|camisolas|calcas|sapatilhas')
        ->where('genero', 'homem|mulher|criança');
    Route::get('/detalhe/{produto}', [ProdutoController::class, 'show'])->name('show');
    Route::get('/busca', [ProdutoController::class, 'search'])->name('search');

    // Rotas que requerem autenticação
    Route::middleware(['auth'])->group(function () {
        // CRUD Produtos
        Route::get('/criar', [ProdutoController::class, 'create'])->name('create');
        Route::post('/criar', [ProdutoController::class, 'store'])->name('store');
        Route::get('/editar/{produto}', [ProdutoController::class, 'edit'])->name('edit');
        Route::put('/editar/{produto}', [ProdutoController::class, 'update'])->name('update');
        Route::delete('/deletar/{produto}', [ProdutoController::class, 'destroy'])->name('destroy');

        // Favoritos
        Route::post('/favorito/{produto}', [ProdutoController::class, 'toggleFavorite'])->name('favorite');
        Route::get('/meus-favoritos', [ProdutoController::class, 'favorites'])->name('favorites');

        // Meus Produtos
        Route::get('/meus', [ProdutoController::class, 'userProducts'])->name('meus');
        Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');
    });
});

// Rotas do Carrinho
Route::prefix('carrinho')->name('carrinho.')->group(function () {
    Route::get('/', [CarrinhoController::class, 'index'])->name('index');
    Route::post('/adicionar', [CarrinhoController::class, 'adicionar'])->name('adicionar');
    Route::delete('/remover/{id}', [CarrinhoController::class, 'remover'])->name('remover');
    Route::patch('/atualizar/{id}', [CarrinhoController::class, 'atualizar'])->name('atualizar');
    Route::delete('/limpar', [CarrinhoController::class, 'limpar'])->name('limpar');
});

// Rotas de Autenticação e Perfil
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rota para mostrar formulário de criação
Route::get('/produtos/criar', [ProdutoController::class, 'create'])->name('produtos.create');

    
// Rota para salvar novo produto
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');

// Outras rotas relacionadas a produtos que precisam de autenticação
Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');
Route::get('/produtos/{produto}/editar', [ProdutoController::class, 'edit'])->name('produtos.edit');
Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    
    // Gestão de utilizadores
    Route::patch('/users/{user}/toggle-ban', [App\Http\Controllers\AdminController::class, 'toggleUserBan'])
        ->name('users.toggle-ban');
    
    // Gestão de produtos
    Route::delete('/produtos/{produto}', [App\Http\Controllers\AdminController::class, 'deleteProduto'])
        ->name('produtos.delete');
    
    // Gestão de categorias
    Route::delete('/categorias/{categoria}', [App\Http\Controllers\CategoriaController::class, 'destroy'])
        ->name('categorias.delete');
    
    // Gestão de géneros
    Route::delete('/generos/{genero}', [App\Http\Controllers\GeneroController::class, 'destroy'])
        ->name('generos.delete');
    
    // Relatórios e estatísticas
    Route::get('/relatorios/vendas', [App\Http\Controllers\AdminController::class, 'relatorioVendas'])
        ->name('relatorios.vendas');
});

require __DIR__ . '/auth.php';

Route::get('/genero/{slug}', [GeneroController::class, 'show'])->name('genero.show');

// Search route
Route::get('/search', [ProdutoController::class, 'search'])->name('search');