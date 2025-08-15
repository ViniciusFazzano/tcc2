<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('user', UsuarioController::class);
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

// — OU — se quiser versionar e/ou proteger:
Route::prefix('v1')->group(function () {
    // protegido por Sanctum (opcional)
    // Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('usuarios', UsuarioController::class);
    // });
});