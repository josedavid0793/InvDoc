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
Route::post('/productos/crear', [ProductoController::class, 'create']);
Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);
Route::put('/productos/{id}', [ProductoController::class, 'update']);


Route::get('/productos/contar', [ProductoController::class, 'contarProductos']);
Route::get('/productos/costo-total', [ProductoController::class, 'obtenerCostoTotal']);
Route::get('/productos/export/pdf', [ProductoController::class, 'exportPdf']);
Route::get('/productos/export/excel', [ProductoController::class, 'exportExcel']);
Route::get('/productos/categoria/{nombreCategoria}', [ProductoController::class, 'productoPorCategoria']);




// Rutas de Categorías
Route::get('/categorias', [CategoriaController::class,'index']);
Route::post('/categorias/crear', [CategoriaController::class, 'store']);
Route::get('/categorias/{{id}}', [CategoriaController::class, 'show']);
Route::put('/categorias/{{id}}', [CategoriaController::class, 'update']);
Route::delete('/categorias/{{id}}', [CategoriaController::class, 'delete']);




// Rutas de Usuarios (excepto registro)
//Route::apiResource('usuarios', UsuarioController::class)->except(['store']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('usuarios/registro', [UsuarioController::class, 'store']);

/*
// Rutas protegidas
Route::group(['middleware' => 'auth:sanctum'], function () {

});
*/


