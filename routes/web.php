<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use Database\Seeders\AdminSeeder;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminMiddleware;




Route::get('/', [ProdutoController::class, 'welcome'])->name('welcome');


// Products routes
Route::prefix('produtos')->name('produtos.')->group(function () {
    // Public routes
    Route::get('/', [ProdutoController::class, 'index'])->name('index');
    Route::get('/search', [ProdutoController::class, 'search'])->name('search');
    Route::get('/categoria/{categoria}/{genero}', [ProdutoController::class, 'categoria'])->name('categoria'); // Add this line
    Route::get('/detalhe/{produto}', [ProdutoController::class, 'show'])->name('show');

    // Authenticated routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/meus', [ProdutoController::class, 'userProducts'])->name('meus');
        Route::post('/', [ProdutoController::class, 'store'])->name('store');
        Route::get('/{produto}/editar', [ProdutoController::class, 'edit'])->name('edit');
        Route::put('/{produto}', [ProdutoController::class, 'update'])->name('update');
        Route::delete('/{produto}', [ProdutoController::class, 'destroy'])->name('destroy');
        Route::post('/{produto}/favorite', [ProdutoController::class, 'toggleFavorite'])->name('favorite');
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
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Mover a rota show para depois das outras rotas do perfil
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    // Outras rotas do perfil
    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::get('/profile/produtos', [ProfileController::class, 'produtos'])->name('profile.products');
});

// Admin routes group
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); // Changed from admin.dashboard

    // Users management routes
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Categories management
    Route::resource('categorias', CategoriaController::class)->except(['show']);
});
Route::resource('categorias', CategoriaController::class)->except(['show']);

// Dashboard
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

// Categories management - using resource route


// Users
Route::get('/users', [AdminController::class, 'users'])->name('users.index');
Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');


// Products
Route::delete('/produtos/{produto}', [AdminController::class, 'deleteProduto'])->name('produtos.delete');


// Public category routes - keep these
Route::get('/produtos/{genero}/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');
Route::get('/api/categorias/{genero}', [CategoriaController::class, 'porGenero']);

// contactos

// Product routes
Route::middleware(['auth'])->group(function () {
    Route::get('/produtos/criar', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');
    Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
});



require __DIR__ . '/auth.php';
