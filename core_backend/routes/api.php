<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\GastosController;


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
Route::get('/categorias/{id}', [CategoriaController::class, 'show']);
Route::put('/categorias/{id}', [CategoriaController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy']);

// Rutas de ventas
Route::get('/ventas/suma-total', [VentasController::class, 'sumarVentasTotales']);
Route::get('/ventas/total', [VentasController::class, 'contarVentas']);
Route::get('/ventas/total-abonos', [VentasController::class, 'contarVentasAbonos']);
Route::get('/ventas/efectivo-total', [VentasController::class, 'obtenerTotalVentasPorEfectivo']);
Route::get('/ventas/no-efectivo-total', [VentasController::class, 'obtenerTotalVentasNoEfectivo']);
Route::get('/ventas/credito/efectivo-total', [VentasController::class, 'obtenerTotalVentasAcreditoEfectivo']);
Route::get('/ventas/credito/no-efectivo-total', [VentasController::class, 'obtenerTotalVentasCreditoNoEfectivo']);
Route::get('/ventas/totales', [VentasController::class, 'getTotalesCostosPrecios']);
Route::get('/balance-reporte/pdf', [VentasController::class, 'exportarReportePDF']);
Route::get('/balance-reporte/excel', [VentasController::class, 'exportarReporteExcel']);
Route::get('/ventas', [VentasController::class,'index']);
Route::post('/ventas', [VentasController::class,'store']);
Route::get('/ventas/{id}', [VentasController::class,'show']);
Route::put('/ventas/{id}', [VentasController::class,'update']);
Route::delete('/ventas/{id}', [VentasController::class,'destroy']);



//Rutas de gastos
Route::get('/gastos/suma-total', [GastosController::class, 'sumarGastosTotales']);
Route::get('/gastos/efectivo-total', [GastosController::class, 'obtenerTotalGastosPorEfectivo']);
Route::get('/gastos/no-efectivo-total', [GastosController::class, 'obtenerTotalGastosNoEfectivo']);
Route::get('/gastos/credito/efectivo-total', [GastosController::class, 'obtenerTotalGastosPorEfectivoCredito']);
Route::get('/gastos/credito/no-efectivo-total', [GastosController::class, 'obtenerTotalGastosNoEfectivoCredito']);

Route::get('/gastos/total', [GastosController::class, 'contarGastos']);
Route::get('/gastos', [GastosController::class,'index']);
Route::post('/gastos', [GastosController::class,'store']);


// Rutas de clientes
Route::get('/clientes', [ClientesController::class,'index']);
Route::post('/clientes/crear', [ClientesController::class, 'store']);




// Rutas de Usuarios (excepto registro)
//Route::apiResource('usuarios', UsuarioController::class)->except(['store']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('usuarios/registro', [UsuarioController::class, 'store']);

/*
// Rutas protegidas
Route::group(['middleware' => 'auth:sanctum'], function () {

});
*/


