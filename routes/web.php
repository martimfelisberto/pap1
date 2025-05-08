<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// Welcome route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Public routes
Route::get('/contactos', function () {
    return view('contactos');
})->name('contactos');

Route::get('/welcome', function () {
    if (Auth::check() && Auth::user()->is_banned) {
        return redirect()->route('banned');
    }
    
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
    
// Products public routes
Route::prefix('produtos')->name('produtos.')->group(function () {
    Route::get('/', [ProdutoController::class, 'index'])->name('index');
    Route::get('/{categoria}/{genero}', [ProdutoController::class, 'categoria'])
        ->name('categoria')
        ->where('categoria', 'casacos|tshirts|camisolas|calcas|sapatilhas')
        ->where('genero', 'homem|mulher|criança');
    Route::get('/detalhe/{produto}', [ProdutoController::class, 'show'])->name('show');
    Route::get('/search', [ProdutoController::class, 'search'])->name('search');

    // Authenticated product routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/criar', [ProdutoController::class, 'create'])->name('create');
        Route::post('/', [ProdutoController::class, 'store'])->name('store');
        Route::get('/{produto}/editar', [ProdutoController::class, 'edit'])->name('edit');
        Route::put('/{produto}', [ProdutoController::class, 'update'])->name('update');
        Route::delete('/{produto}', [ProdutoController::class, 'destroy'])->name('destroy');
        Route::post('/{produto}/favorite', [ProdutoController::class, 'toggleFavorite'])->name('favorite');
        Route::get('/meus', [ProdutoController::class, 'userProducts'])->name('meus');
        Route::get('/meus-favoritos', [ProdutoController::class, 'favorites'])->name('favorites');
    });
});

// Cart routes
Route::middleware(['auth'])->prefix('carrinho')->name('carrinho.')->group(function () {
    Route::get('/', [CarrinhoController::class, 'index'])->name('index');
    Route::post('/adicionar', [CarrinhoController::class, 'adicionar'])->name('adicionar');
    Route::delete('/remover/{id}', [CarrinhoController::class, 'remover'])->name('remover');
    Route::patch('/atualizar/{id}', [CarrinhoController::class, 'atualizar'])->name('atualizar');
    Route::delete('/limpar', [CarrinhoController::class, 'limpar'])->name('limpar');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::get('/profile/produtos', [ProfileController::class, 'produtos'])->name('profile.products');
    Route::get('/profile/vendas', [ProfileController::class, 'vendas'])->name('profile.sales');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('categorias', CategoriaController::class)->except(['index', 'show']);
    Route::get('/produtos', [AdminController::class, 'produtos'])->name('produtos.index');
    Route::delete('/produtos/{produto}', [AdminController::class, 'deleteProduto'])->name('produtos.delete');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::patch('/users/{user}/toggle-ban', [AdminController::class, 'toggleUserBan'])->name('users.toggle-ban');
    
    // Reports
    Route::get('/relatorios/vendas', [AdminController::class, 'relatorioVendas'])->name('relatorios.vendas');
});

// Género routes
Route::get('/genero/{slug}', [GeneroController::class, 'show'])->name('genero.show');

require __DIR__ . '/auth.php';