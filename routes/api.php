<?php

use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\OpcoesVariacoesController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VariacaoController;
use App\Models\OpcoesVariacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('variacoes', VariacaoController::class);
Route::resource('produtos', ProdutoController::class);
Route::resource('opcoesvariacoes', OpcoesVariacoesController::class);
Route::resource('estoques', EstoqueController::class);
