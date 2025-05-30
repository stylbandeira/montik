<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    return Inertia::render(('Home'));
});

// Route::get('/produtos', [ProdutoController::class, 'create'])->name('produto.create');
Route::middleware(['auth'])->group(function () {
    Route::get('/produtos', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

// Route::get('/comprar', function () {
//     return Inertia::render('Comprar');
// });

Route::get('/comprar', [ProdutoController::class, 'list'])->name('produto.list');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/', [ProdutoController::class, 'create'])->name('produto.create');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedido.store');

require __DIR__ . '/auth.php';
