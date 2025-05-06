<?php

use App\Http\Controllers\AlertaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaProductoController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);


Route::apiResource('ventas', VentaController::class);
Route::apiResource('detalle-ventas', DetalleVentaProductoController::class);

// Aquí puedes definir tus rutas de API
Route::get('/health', function() {
    return response()->json(['message' => 'API funcionando']);
});

Route::apiResource('users', UserController::class);
Route::apiResource('proveedores', ProveedoresController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('alertas', AlertaController::class);
