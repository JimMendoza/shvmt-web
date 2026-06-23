<?php

use App\Http\Controllers\Api\Admin\Contenido\ColaboradorController;
use App\Http\Controllers\Api\Admin\Contenido\ComunicadoController;
use App\Http\Controllers\Api\Admin\Contenido\ConfiguracionSitioController;
use App\Http\Controllers\Api\Admin\Contenido\EntradaHistoricaController;
use App\Http\Controllers\Api\Admin\Contenido\MayordomiaController;
use App\Http\Controllers\Api\Admin\Contenido\SeccionHistoriaController;
use App\Http\Controllers\Api\Admin\Contenido\UbicacionController;
use App\Http\Controllers\Api\Admin\Dashboard\PanelController;
use App\Http\Controllers\Api\Admin\Galeria\AlbumController;
use App\Http\Controllers\Api\Admin\Galeria\FotoController;
use App\Http\Controllers\Api\Admin\Multimedia\VideoController;
use App\Http\Controllers\Api\Admin\Programa\ActividadProgramaController;
use App\Http\Controllers\Api\Admin\Programa\DiaProgramaController;
use App\Http\Controllers\Api\Admin\Seguridad\PermisoController;
use App\Http\Controllers\Api\Admin\Seguridad\RolController;
use App\Http\Controllers\Api\Admin\Seguridad\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(['auth:sanctum', 'cambio.contrasena'])
    ->group(function () {
        Route::get('/dashboard', [PanelController::class, 'resumen'])
            ->middleware('can:dashboard.ver');

        Route::apiResource('/configuracion-sitio', ConfiguracionSitioController::class)
            ->middleware('can:configuracion.editar');
        Route::apiResource('/historia', SeccionHistoriaController::class)
            ->middleware('can:historia.administrar');
        Route::apiResource('/mayordomias', MayordomiaController::class)
            ->middleware('can:mayordomia.administrar');
        Route::apiResource('/dias-programa', DiaProgramaController::class)
            ->middleware('can:programa.administrar');
        Route::apiResource('/actividades-programa', ActividadProgramaController::class)
            ->middleware('can:programa.administrar');
        Route::apiResource('/albumes', AlbumController::class)
            ->middleware('can:galeria.administrar');
        Route::apiResource('/fotos', FotoController::class)
            ->middleware('can:galeria.administrar');
        Route::apiResource('/videos', VideoController::class)
            ->middleware('can:videos.administrar');
        Route::apiResource('/comunicados', ComunicadoController::class)
            ->middleware('can:comunicados.administrar');
        Route::apiResource('/ubicaciones', UbicacionController::class)
            ->middleware('can:ubicaciones.administrar');
        Route::apiResource('/colaboradores', ColaboradorController::class)
            ->middleware('can:colaboradores.administrar');
        Route::apiResource('/archivo-historico', EntradaHistoricaController::class)
            ->middleware('can:archivo_historico.administrar');

        Route::get('/permisos', [PermisoController::class, 'index'])
            ->middleware('can:seguridad.roles.ver');
        Route::apiResource('/usuarios', UsuarioController::class)
            ->middleware('can:seguridad.usuarios.administrar');
        Route::put('/usuarios/{usuario}/roles', [UsuarioController::class, 'asignarRoles'])
            ->middleware('can:seguridad.usuarios.administrar');
        Route::apiResource('/roles', RolController::class)
            ->middleware('can:seguridad.roles.administrar');
        Route::put('/roles/{rol}/permisos', [RolController::class, 'asignarPermisos'])
            ->middleware('can:seguridad.roles.asignar_permisos');
    });
