<?php

namespace Database\Seeders;

use App\Models\Contenido\Colaborador;
use App\Models\Contenido\Comunicado;
use App\Models\Contenido\ConfiguracionSitio;
use App\Models\Contenido\EntradaHistorica;
use App\Models\Contenido\Mayordomia;
use App\Models\Contenido\SeccionHistoria;
use App\Models\Contenido\Ubicacion;
use App\Models\Galeria\Album;
use App\Models\Multimedia\Video;
use App\Models\Programa\DiaPrograma;
use Illuminate\Database\Seeder;

class ContenidoInicialSeeder extends Seeder
{
    public function run(): void
    {
        ConfiguracionSitio::query()->updateOrCreate(
            ['id' => 1],
            [
                'nombre_sitio' => 'Festividad del Señor de Huanca VMT',
                'subtitulo_sitio' => 'Fe, tradición y memoria viva',
                'anio_principal' => now()->year,
                'titulo_portada' => 'Señor de Huanca en Villa María del Triunfo',
                'subtitulo_portada' => 'Sitio oficial de la festividad, su historia y su programa.',
                'color_primario' => '#6E1B2F',
                'color_secundario' => '#C9A227',
            ],
        );

        SeccionHistoria::query()->updateOrCreate(
            ['id' => 1],
            [
                'titulo' => 'Historia de la devoción',
                'subtitulo' => 'Memoria de fe y comunidad',
                'contenido' => 'Contenido inicial pendiente de revisión.',
                'orden' => 1,
                'publicado' => true,
            ],
        );

        Mayordomia::query()->updateOrCreate(
            ['anio' => now()->year],
            [
                'titulo' => 'Mayordomía principal',
                'nombre_familia' => 'Familia devota',
                'mensaje' => 'Mensaje inicial pendiente de revisión.',
                'actual' => true,
                'publicado' => true,
            ],
        );

        $dia = DiaPrograma::query()->updateOrCreate(
            ['fecha' => now()->toDateString()],
            [
                'titulo' => 'Día central',
                'descripcion' => 'Programa inicial pendiente de confirmación.',
                'orden' => 1,
                'publicado' => true,
            ],
        );

        $dia->actividades()->updateOrCreate(
            ['titulo' => 'Misa principal'],
            [
                'descripcion' => 'Actividad inicial pendiente de confirmación.',
                'hora_inicio' => '10:00',
                'nombre_lugar' => 'Templo principal',
                'orden' => 1,
                'publicado' => true,
            ],
        );

        Album::query()->updateOrCreate(
            ['slug' => 'archivo-fotografico'],
            [
                'titulo' => 'Archivo fotográfico',
                'descripcion' => 'Álbum inicial para futuras fotografías.',
                'anio' => now()->year,
                'orden' => 1,
                'publicado' => true,
            ],
        );

        Video::query()->updateOrCreate(
            ['slug' => 'video-inicial'],
            [
                'titulo' => 'Video inicial',
                'descripcion' => 'Video embebido pendiente de actualización.',
                'url_video' => 'https://www.youtube.com/',
                'url_incrustado' => 'https://www.youtube.com/embed/',
                'categoria' => 'archivo',
                'anio' => now()->year,
                'orden' => 1,
                'destacado' => true,
                'publicado' => true,
            ],
        );

        Comunicado::query()->updateOrCreate(
            ['slug' => 'bienvenida'],
            [
                'titulo' => 'Bienvenida',
                'contenido' => 'Comunicado inicial pendiente de revisión.',
                'destacado' => true,
                'publicado' => true,
                'publicado_en' => now(),
            ],
        );

        Ubicacion::query()->updateOrCreate(
            ['id' => 1],
            [
                'titulo' => 'Ubicación principal',
                'descripcion' => 'Ubicación inicial pendiente de actualización.',
                'direccion' => 'Villa María del Triunfo, Lima',
                'tipo' => 'iglesia',
                'orden' => 1,
                'publicado' => true,
            ],
        );

        Colaborador::query()->updateOrCreate(
            ['id' => 1],
            [
                'nombre' => 'Comunidad devota',
                'descripcion' => 'Registro inicial de colaboradores.',
                'tipo' => 'colaborador',
                'orden' => 1,
                'publicado' => true,
            ],
        );

        EntradaHistorica::query()->updateOrCreate(
            ['anio' => now()->year],
            [
                'titulo' => 'Archivo histórico inicial',
                'descripcion' => 'Entrada inicial pendiente de revisión.',
                'mayordomos' => 'Pendiente',
                'orden' => 1,
                'publicado' => true,
            ],
        );
    }
}
