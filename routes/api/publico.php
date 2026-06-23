<?php

use App\Http\Controllers\Api\Publico\ContenidoController;
use App\Http\Controllers\Api\Publico\GaleriaController;
use App\Http\Controllers\Api\Publico\ProgramaController;
use App\Http\Controllers\Api\Publico\VideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('publico')->group(function () {
    Route::get('/configuracion-sitio', [ContenidoController::class, 'configuracion']);
    Route::get('/historia', [ContenidoController::class, 'historia']);
    Route::get('/mayordomia', [ContenidoController::class, 'mayordomia']);
    Route::get('/programa', [ProgramaController::class, 'index']);
    Route::get('/albumes', [GaleriaController::class, 'albumes']);
    Route::get('/albumes/{slug}', [GaleriaController::class, 'album']);
    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/videos/{slug}', [VideoController::class, 'show']);
    Route::get('/comunicados', [ContenidoController::class, 'comunicados']);
    Route::get('/comunicados/{slug}', [ContenidoController::class, 'comunicado']);
    Route::get('/ubicaciones', [ContenidoController::class, 'ubicaciones']);
    Route::get('/colaboradores', [ContenidoController::class, 'colaboradores']);
    Route::get('/archivo-historico', [ContenidoController::class, 'archivoHistorico']);
});
