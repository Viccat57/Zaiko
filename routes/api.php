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




Route::get('/proveedores', [ProveedoresController::class, 'index']);
Route::get('/alertas', [AlertaController::class, 'index']);
Route::post('/alertas', [AlertaController::class, 'store']);
Route::put('/alertas/{id}', [AlertaController::class, 'update']);
Route::delete('/alertas/{id}', [AlertaController::class, 'destroy']);


Route::get('/health', function() {
    return response()->json(['message' => 'API funcionando']);
});

Route::apiResource('users', UserController::class);
Route::apiResource('proveedores', ProveedoresController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('alertas', AlertaController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::apiResource('ventas', VentaController::class);
Route::apiResource('detalle-ventas', DetalleVentaProductoController::class);

