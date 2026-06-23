<?php

use App\Http\Controllers\Api\Autenticacion\AutenticacionController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('auth')->group(function () {
    Route::post('/login', [AutenticacionController::class, 'iniciarSesion']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AutenticacionController::class, 'usuarioActual']);
        Route::patch('/contrasena', [AutenticacionController::class, 'cambiarContrasena']);
        Route::post('/logout', [AutenticacionController::class, 'cerrarSesion']);
    });
});
