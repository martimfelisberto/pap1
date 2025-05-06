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

Route::get('/', function () {
    return view('welcome');
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
    });


Route::get('/contactos', function () {
    return view('contactos');

});

// Rotas de Produtos
Route::prefix('produtos')->name('produtos.')->group(function () {
    // Rotas públicas
    Route::get('/', [ProdutoController::class, 'index'])->name('index');
    Route::get('/{categoria}/{genero}', [ProdutoController::class, 'categoria'])
        ->name('categoria')
        ->where('categoria', 'casacos|tshirts|camisolas|calcas|sapatilhas')
        ->where('genero', 'homem|mulher|crianca');
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
        Route::get('/meus-produtos', [ProdutoController::class, 'myProducts'])->name('my-products');
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

require __DIR__ . '/auth.php';

Route::get('/genero/{slug}', [GeneroController::class, 'show'])->name('genero.show');