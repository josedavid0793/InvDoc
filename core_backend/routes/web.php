<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;



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

Route::get('/', function () {
    return view('welcome');
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
