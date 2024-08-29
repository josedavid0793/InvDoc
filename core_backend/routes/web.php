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
