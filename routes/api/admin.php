<?php

use App\Http\Controllers\Api\Admin\Dashboard\PanelController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(['auth:sanctum', 'cambio.contrasena'])
    ->group(function () {
        Route::get('/dashboard', [PanelController::class, 'resumen'])
            ->middleware('can:dashboard.ver');
    });
