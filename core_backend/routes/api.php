<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
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
Route::get('/productos',[ProductoController::class,'index']);
Route::post('/productos',[ProductoController::class,'create']);
Route::get('/productos/{id}',[ProductoController::class,'show']);
Route::put('/productos/{id}',[ProductoController::class,'update']);
Route::delete('/productos/{id}',[ProductoController::class,'destroy']);

Route::get('/categorias',[CategoriaController::class,'index']);
Route::post('/categorias',[CategoriaController::class,'store']);
Route::get('/categorias/{id}',[CategoriaController::class,'show']);
Route::put('/categorias/{id}',[CategoriaController::class,'update']);
Route::delete('/categorias/{id}',[CategoriaController::class,'destroy']);

Route::get('/usuarios',[UsuarioController::class,'index']);
Route::post('/usuarios',[UsuarioController::class,'store']);
Route::get('/usuarios/{id}',[UsuarioController::class,'show']);
Route::put('/usuarios/{id}',[UsuarioController::class,'update']);
Route::delete('/usuarios/{id}',[UsuarioController::class,'destroy']);







