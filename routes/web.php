<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('xd');
});

Route::get('/health', function() {
    return response()->json(['message' => 'API funcionando']);
});