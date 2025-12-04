<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AssinaturaController;
use App\Http\Middleware\ClienteAuth;

/*
|--------------------------------------------------------------------------
| Site (Cliente)
|--------------------------------------------------------------------------
*/
Route::get('/', [ProdutoController::class, 'home'])->name('site.home');

/*
|--------------------------------------------------------------------------
| Login Admin (visitante)
|--------------------------------------------------------------------------
*/
Route::middleware('guest.admin')->prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'loginView'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
});

/*
|--------------------------------------------------------------------------
| Painel Admin (PROTEGIDO)
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // CRUD Usuários Administradores
    Route::prefix('usuarios')->group(function () {
        Route::get('/listar', [AdminController::class, 'index'])->name('admin.usuarios.listar');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.usuarios.create');
        Route::post('/', [AdminController::class, 'store'])->name('admin.usuarios.store');
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('admin.usuarios.editar');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('admin.usuarios.update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('admin.usuarios.delete');
    });

    // CRUD Clientes
    Route::prefix('clientes')->group(function () {
        Route::get('/listar', [ClienteController::class, 'index'])->name('admin.clientes.listar');
        Route::get('/create', [ClienteController::class, 'create'])->name('admin.clientes.create');
        Route::post('/', [ClienteController::class, 'store'])->name('admin.clientes.store');
        Route::get('/{cliente}/edit', [ClienteController::class, 'edit'])->name('admin.clientes.edit');
        Route::put('/{cliente}', [ClienteController::class, 'update'])->name('admin.clientes.update');
        Route::delete('/{cliente}', [ClienteController::class, 'destroy'])->name('admin.clientes.delete');
    });

    // CRUD Produtos
    Route::prefix('produtos')->group(function () {

        Route::get('/', [ProdutoController::class, 'indexAdmin'])->name('admin.produtos.index');
        Route::get('/create', [ProdutoController::class, 'create'])->name('admin.produtos.create');
        Route::post('/', [ProdutoController::class, 'store'])->name('admin.produtos.store');
        Route::get('/{produto}/edit', [ProdutoController::class, 'edit'])->name('admin.produtos.edit');
        Route::put('/{produto}', [ProdutoController::class, 'update'])->name('admin.produtos.update');

        Route::get('/{produto}/delete', [ProdutoController::class, 'confirmDelete'])
            ->name('admin.produtos.confirm-delete');

        Route::delete('/{produto}', [ProdutoController::class, 'destroy'])
            ->name('admin.produtos.delete');
    });

    // Logout Admin
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| Autenticação do Cliente (visitante)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [ClienteController::class, 'loginView'])->name('cliente.loginView');
    Route::post('/login', [ClienteController::class, 'login'])->name('cliente.login');
    Route::get('/cadastro', [ClienteController::class, 'create'])->name('cliente.cadastro');
    Route::post('/cadastro', [ClienteController::class, 'store'])->name('cliente.store');
});

/*
|--------------------------------------------------------------------------
| Dashboard, perfil e assinaturas do Cliente (PROTEGIDO)
|--------------------------------------------------------------------------
*/
Route::middleware([ClienteAuth::class])->prefix('cliente')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ClienteController::class, 'dashboard'])->name('cliente.dashboard');

    // Logout
    Route::post('/logout', [ClienteController::class, 'logout'])->name('cliente.logout');

    // Perfil
    Route::get('/edit', [ClienteController::class, 'edit'])->name('cliente.edit');
    Route::put('/update', [ClienteController::class, 'update'])->name('cliente.update');

    // Assinaturas (página)
    Route::get('/assinaturas', [AssinaturaController::class, 'index'])->name('cliente.assinaturas');

    // ➕ AJAX: carregar assinaturas dentro do painel
    Route::get('/assinaturas/listar/ajax', [ClienteController::class, 'listarAssinaturas'])
        ->name('cliente.assinaturas.ajax');

    // Checkout protegido
    Route::get('/assinaturas/checkout/{produto}', [AssinaturaController::class, 'checkout'])
        ->name('cliente.assinaturas.checkout');

    // Finalizar assinatura
    Route::post('/assinaturas/{produto}', [AssinaturaController::class, 'store'])
        ->name('cliente.assinaturas.store');

    Route::delete('/assinaturas/{assinatura}/cancelar', [AssinaturaController::class, 'cancelar'])
    ->name('cliente.assinaturas.cancelar');

    Route::delete('/assinaturas/{assinatura}/deletar', [AssinaturaController::class, 'deletar'])
    ->name('cliente.assinaturas.deletar');



});

/*
|--------------------------------------------------------------------------
| Redirecionar "comprar" para login se visitante
|--------------------------------------------------------------------------
*/
Route::get('/comprar/{produto}', function($produto) {

    // Se logado → vai para checkout
    if(auth('cliente')->check()){
        return redirect()->route('cliente.assinaturas.checkout', $produto);
    }

    // Se NÃO logado → salva destino e envia para login
    session(['url.intended' => route('cliente.assinaturas.checkout', $produto)]);

    return redirect()->route('cliente.loginView');
})->name('site.comprar');
