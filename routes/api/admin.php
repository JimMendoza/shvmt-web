<?php

use App\Http\Controllers\Api\Admin\Catalogos\DepartamentoController;
use App\Http\Controllers\Api\Admin\Catalogos\DistritoController;
use App\Http\Controllers\Api\Admin\Catalogos\ProvinciaController;
use App\Http\Controllers\Api\Admin\Catalogos\SexoController;
use App\Http\Controllers\Api\Admin\Catalogos\TipoDocumentoIdentidadController;
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
use App\Http\Controllers\Api\Admin\Interfaz\MenuController;
use App\Http\Controllers\Api\Admin\Interfaz\MenuItemController;
use App\Http\Controllers\Api\Admin\Interfaz\MenuNavegacionController;
use App\Http\Controllers\Api\Admin\Multimedia\VideoController;
use App\Http\Controllers\Api\Admin\Programa\ActividadProgramaController;
use App\Http\Controllers\Api\Admin\Programa\DiaProgramaController;
use App\Http\Controllers\Api\Admin\Seguridad\PermisoController;
use App\Http\Controllers\Api\Admin\Seguridad\PersonaController;
use App\Http\Controllers\Api\Admin\Seguridad\RolController;
use App\Http\Controllers\Api\Admin\Seguridad\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(['auth:sanctum', 'cambio.contrasena'])
    ->group(function () {
        Route::get('/menu', [MenuNavegacionController::class, 'index']);

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

        Route::prefix('catalogos')->group(function () {
            Route::apiResource('/sexos', SexoController::class)
                ->middleware('can:catalogos.sexos.administrar');
            Route::apiResource('/tipos-documento-identidad', TipoDocumentoIdentidadController::class)
                ->middleware('can:catalogos.tipos_documento.administrar');
            Route::apiResource('/departamentos', DepartamentoController::class)
                ->middleware('can:catalogos.departamentos.administrar');
            Route::apiResource('/provincias', ProvinciaController::class)
                ->middleware('can:catalogos.provincias.administrar');
            Route::apiResource('/distritos', DistritoController::class)
                ->middleware('can:catalogos.distritos.administrar');
        });

        Route::prefix('interfaz')->group(function () {
            Route::apiResource('/menus', MenuController::class)
                ->middleware('can:interfaz.menus.administrar');
            Route::apiResource('/menu-items', MenuItemController::class)
                ->middleware('can:interfaz.menu_items.administrar');
        });

        Route::get('/permisos', [PermisoController::class, 'index'])
            ->middleware('can:seguridad.roles.ver');
        Route::apiResource('/personas', PersonaController::class)
            ->middleware('can:seguridad.personas.administrar');
        Route::apiResource('/usuarios', UsuarioController::class)
            ->middleware('can:seguridad.usuarios.administrar');
        Route::put('/usuarios/{usuario}/roles', [UsuarioController::class, 'asignarRoles'])
            ->middleware('can:seguridad.usuarios.administrar');
        Route::apiResource('/roles', RolController::class)
            ->middleware('can:seguridad.roles.administrar');
        Route::put('/roles/{rol}/permisos', [RolController::class, 'asignarPermisos'])
            ->middleware('can:seguridad.roles.asignar_permisos');
    });
