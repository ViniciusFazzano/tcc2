<?php

use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Versão básica, pública (sem auth)
Route::apiResource('usuarios', UsuarioController::class);

// — OU — se quiser versionar e/ou proteger:
Route::prefix('v1')->group(function () {
    // protegido por Sanctum (opcional)
    // Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('usuarios', UsuarioController::class);
    // });
});