<?php

// Importação dos controladores e outras classes necessárias para a aplicação
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
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Rota principal da aplicação
Route::get('/', [ProdutoController::class, 'welcome'])->name('welcome');

 
// Grupo de rotas para os produtos
Route::prefix('produtos')->name('produtos.')->group(function () {
    // Public routes (rotas públicas acessíveis a todos)
    Route::get('/', [ProdutoController::class, 'index'])->name('index'); // Lista de todos os produtos
    Route::get('/search', [ProdutoController::class, 'search'])->name('search'); // Pesquisa de produtos
    Route::get('/categoria/{categoria}/{genero}', [ProdutoController::class, 'categoria'])->name('categoria'); // Add this line - Filtra produtos por categoria e género
    Route::get('/detalhe/{produto}', [ProdutoController::class, 'show'])->name('show'); // Mostra detalhes de um produto

    // Authenticated routes (rotas acessíveis apenas a utilizadores autenticados)
    Route::middleware(['auth'])->group(function () {
        Route::get('/meus', [ProdutoController::class, 'userProducts'])->name('meus'); // Lista dos produtos do utilizador autenticado
        Route::post('/', [ProdutoController::class, 'store'])->name('store'); // Cria um novo produto
        Route::get('/{produto}/editar', [ProdutoController::class, 'edit'])->name('edit'); // Página para editar um produto
        Route::put('/{produto}', [ProdutoController::class, 'update'])->name('update'); // Atualiza o produto
        Route::delete('/{produto}', [ProdutoController::class, 'destroy'])->name('destroy'); // Apaga o produto
      });
});

// Grupo de rotas para o carrinho (acessíveis apenas a utilizadores autenticados)
Route::middleware(['auth'])->prefix('carrinho')->name('carrinho.')->group(function () {
    Route::post('/adicionar', [CarrinhoController::class, 'adicionar'])->name('adicionar'); // Adiciona um produto ao carrinho
    Route::get('/', [CarrinhoController::class, 'index'])->name('index'); // Mostra o carrinho de compras
    Route::patch('/atualizar/{id}', [CarrinhoController::class, 'atualizar'])->name('atualizar'); // Atualiza um item do carrinho
    Route::delete('/remover/{id}', [CarrinhoController::class, 'remover'])->name('remover'); // Remove um item do carrinho
    Route::delete('/limpar', [CarrinhoController::class, 'limpar'])->name('limpar'); // Limpa o carrinho
});

// Grupo de rotas para o perfil (apenas para utilizadores autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Página de edição do perfil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Atualização dos dados do perfil
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo'); // Atualiza a foto do perfil
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password'); // Altera a password do perfil
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Remove o perfil

    // Mover a rota show para depois das outras rotas do perfil
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show'); // Mostra o perfil de um utilizador

    // Outras rotas do perfil
    Route::get('/profile/produtos', [ProfileController::class, 'produtos'])->name('profile.products'); // Lista dos produtos criados pelo utilizador
});

// Grupo de rotas administrativas (acessíveis apenas a utilizadores autenticados)
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users management routes (rota para gestão de utilizadores)
    Route::get('/users', [AdminController::class, 'users'])->name('users.index'); // Lista dos utilizadores
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit'); // Página para editar um utilizador
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update'); // Atualiza os dados do utilizador
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy'); // Remove um utilizador

    // Categories management (gestão de categorias)
    Route::resource('categorias', CategoriaController::class)->except(['show']); // Utiliza resource route para categorias, exceto a rota 'show'
 });
// Recurso duplicado de categorias conforme o código original
Route::resource('categorias', CategoriaController::class)->except(['show']);


// Rota para criação de categoria via POST
Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

// (Comentário: Este comentário original não tem código associado)

// Bloco de rotas para gestão de utilizadores fora do grupo 'admin' (mantido conforme o código original)
Route::get('/users', [AdminController::class, 'users'])->name('users.index'); // Lista dos utilizadores
Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit'); // Página para editar um utilizador
Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update'); // Atualiza os dados do utilizador

// Rota para remoção de produtos pelo administrador

// Rotas públicas para visualização de categorias e produtos por género
Route::get('/produtos/{categoria}/{genero}', [CategoriaController::class, 'show'])->name('categorias.show'); // Mostra produtos por categoria e género
Route::get('/api/categorias/{genero}', [CategoriaController::class, 'porGenero']);

// (Comentário: Nenhuma rota específica para contactos foi definida aqui)

// Grupo de rotas para produtos que requerem autenticação (criação e edição de produtos)
Route::middleware(['auth'])->group(function () {
    Route::get('/produtos/criar', [ProdutoController::class, 'create'])->name('produtos.create'); // Página para criar um novo produto
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store'); // Guarda o novo produto
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index'); // Lista de produtos (possivelmente duplicado)
    Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show'); // Mostra os detalhes de um produto
    Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update'); // Atualiza o produto
 });

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

Route::get('/meus-produtos', [ProdutoController::class, 'myProducts'])->name('produtos.myproducts');

Route::middleware(['auth'])->group(function () {
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favoritos.index');
    Route::post('/favoritos/toggle', [FavoriteController::class, 'toggle'])->name('favoritos.toggle');
});

// Rota para contactos
Route::get('/contactos', [ContactoController::class, 'index'])->name('contactos.index');

// Add this route for submitting the contact form
Route::post('/contactos', [App\Http\Controllers\ContactoController::class, 'store'])->name('contactos.store');


// Inclusão das rotas de autenticação
require __DIR__ . '/auth.php';
