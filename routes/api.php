<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\IaController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\UsuarioController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('user', UsuarioController::class);
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/mandaEmail/redefinicaoSenha', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/redefinicaoSenha', [UsuarioController::class, 'resetPassword']);
Route::post('/ia/perguntar', [IaController::class, 'perguntar']);


Route::prefix('v1')->group(function () {
    // Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('produtos', ProdutoController::class);
    // });
});