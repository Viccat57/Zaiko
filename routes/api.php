<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Aquí puedes definir tus rutas de API
Route::get('/health', function () {
    return response()->json(['message' => 'API funcionando']);
});

Route::apiResource('users', UserController::class);