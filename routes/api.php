<?php

use App\Http\Controllers\AlertaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaProductoController;





Route::get('/alertas', [AlertaController::class, 'index']);
Route::post('/alertas', [AlertaController::class, 'store']);
Route::put('/alertas/{id}', [AlertaController::class, 'update']);
Route::delete('/alertas/{id}', [AlertaController::class, 'destroy']);

Route::post('/proveedores', [ProveedoresController::class, 'store']);
Route::get('/proveedores', [ProveedoresController::class, 'index']);
Route::put('/proveedores/{id}', [ProveedoresController::class, 'update']);
Route::delete('/proveedores/{id}', [ProveedoresController::class, 'destroy']);

// Rutas para Ventas
Route::get('/ventas', [VentaController::class, 'index']);
Route::get('/ventas/{id_venta}', [VentaController::class, 'show']);
Route::post('/ventas', [VentaController::class, 'store']);
Route::put('/ventas/{id_venta}', [VentaController::class, 'update']);
Route::delete('/ventas/{id_venta}', [VentaController::class, 'destroy']);

// Rutas adicionales útiles para ventas
Route::get('/ventas/por-fecha/{fecha}', [VentaController::class, 'ventasPorFecha']);
Route::get('/ventas/por-usuario/{usuarioId}', [VentaController::class, 'ventasPorUsuario']);
Route::get('/ventas/por-producto/{productoId}', [VentaController::class, 'ventasPorProducto']);
Route::get('/ventas/estadisticas/diarias', [VentaController::class, 'estadisticasDiarias']);
Route::get('/ventas/estadisticas/mensuales', [VentaController::class, 'estadisticasMensuales']);


Route::get('/detalle-ventas/{id_venta}', [DetalleVentaProductoController::class, 'show']);
Route::post('/detalle-ventas', [DetalleVentaProductoController::class, 'store']);

Route::get('/productos/multiple', [ProductoController::class, 'getMultiple']);
Route::patch('/productos/{id}/reduce-stock', [ProductoController::class, 'reduceStock']);


Route::get('/health', function() {
    return response()->json(['message' => 'API funcionando']);
});

Route::apiResource('users', UserController::class);

Route::apiResource('productos', ProductoController::class);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::apiResource('ventas', VentaController::class);
Route::apiResource('detalle-ventas', DetalleVentaProductoController::class);

