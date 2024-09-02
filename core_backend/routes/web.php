<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;




// Rutas públicas

Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::get('me', [AuthController::class, 'me']);

// Rutas de Productos
//Route::apiResource('productos', ProductoController::class);
Route::get('/productos', [ProductoController::class, 'index']);
Route::post('/productos', [ProductoController::class, 'create']);
Route::get('/productos/contar', [ProductoController::class, 'contarProductos']);
Route::get('/productos/costo-total', [ProductoController::class, 'obtenerCostoTotal']);



// Rutas de Categorías
Route::apiResource('categorias', CategoriaController::class);

// Rutas de Usuarios (excepto registro)
Route::apiResource('usuarios', UsuarioController::class)->except(['store']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('usuarios/registro', [UsuarioController::class, 'store']);
/*
// Rutas protegidas
Route::group(['middleware' => 'auth:sanctum'], function () {

});

*/

