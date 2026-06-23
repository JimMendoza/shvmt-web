<?php

namespace Tests\Feature\Publico;

use App\Models\Contenido\Comunicado;
use App\Models\Contenido\SeccionHistoria;
use App\Models\Galeria\Album;
use App\Models\Galeria\Foto;
use App\Models\Multimedia\Video;
use App\Models\Programa\DiaPrograma;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiPublicaTest extends TestCase
{
    use RefreshDatabase;

    public function test_historia_devuelve_solo_secciones_publicadas(): void
    {
        SeccionHistoria::query()->create([
            'titulo' => 'Publicado',
            'orden' => 2,
            'publicado' => true,
        ]);

        SeccionHistoria::query()->create([
            'titulo' => 'Oculto',
            'orden' => 1,
            'publicado' => false,
        ]);

        $this->getJson('/api/publico/historia')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.titulo', 'Publicado');
    }

    public function test_programa_devuelve_solo_dias_y_actividades_publicadas(): void
    {
        $dia = DiaPrograma::query()->create([
            'titulo' => 'Día publicado',
            'fecha' => '2026-09-14',
            'publicado' => true,
        ]);

        $dia->actividades()->create([
            'titulo' => 'Actividad publicada',
            'publicado' => true,
        ]);

        $dia->actividades()->create([
            'titulo' => 'Actividad oculta',
            'publicado' => false,
        ]);

        DiaPrograma::query()->create([
            'titulo' => 'Día oculto',
            'fecha' => '2026-09-13',
            'publicado' => false,
        ]);

        $this->getJson('/api/publico/programa')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.titulo', 'Día publicado')
            ->assertJsonCount(1, '0.actividades')
            ->assertJsonPath('0.actividades.0.titulo', 'Actividad publicada');
    }

    public function test_album_devuelve_solo_fotos_publicadas(): void
    {
        $album = Album::query()->create([
            'titulo' => 'Álbum publicado',
            'slug' => 'album-publicado',
            'publicado' => true,
        ]);

        Foto::query()->create([
            'album_id' => $album->id,
            'titulo' => 'Foto publicada',
            'ruta_archivo' => 'fotos/publicada.jpg',
            'publicado' => true,
        ]);

        Foto::query()->create([
            'album_id' => $album->id,
            'titulo' => 'Foto oculta',
            'ruta_archivo' => 'fotos/oculta.jpg',
            'publicado' => false,
        ]);

        $this->getJson('/api/publico/albumes/album-publicado')
            ->assertOk()
            ->assertJsonPath('titulo', 'Álbum publicado')
            ->assertJsonCount(1, 'fotos')
            ->assertJsonPath('fotos.0.titulo', 'Foto publicada');
    }

    public function test_detalles_publicos_no_muestran_registros_ocultos(): void
    {
        Comunicado::query()->create([
            'titulo' => 'Comunicado oculto',
            'slug' => 'comunicado-oculto',
            'publicado' => false,
        ]);

        Video::query()->create([
            'titulo' => 'Video oculto',
            'slug' => 'video-oculto',
            'url_video' => 'https://www.youtube.com/',
            'publicado' => false,
        ]);

        $this->getJson('/api/publico/comunicados/comunicado-oculto')->assertNotFound();
        $this->getJson('/api/publico/videos/video-oculto')->assertNotFound();
    }
}
