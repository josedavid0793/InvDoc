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
Route::get('/api/productos',[ProductoController::class,'index']);
Route::post('/api/productos',[ProductoController::class,'create']);
Route::get('/api/productos/{id}',[ProductoController::class,'show']);
Route::put('/api/productos/{id}',[ProductoController::class,'update']);
Route::delete('/api/productos/{id}',[ProductoController::class,'destroy']);

Route::get('/api/categorias',[CategoriaController::class,'index']);
Route::post('/api/categorias',[CategoriaController::class,'store']);
Route::get('/api/categorias/{id}',[CategoriaController::class,'show']);
Route::put('/api/categorias/{id}',[CategoriaController::class,'update']);
Route::delete('/api/categorias/{id}',[CategoriaController::class,'destroy']);

Route::get('/api/usuarios',[UsuarioController::class,'index']);
Route::post('/api/usuarios',[UsuarioController::class,'store']);
Route::get('/api/usuarios/{id}',[UsuarioController::class,'show']);
Route::put('/api/usuarios/{id}',[UsuarioController::class,'update']);
Route::delete('/api/usuarios/{id}',[UsuarioController::class,'destroy']);







