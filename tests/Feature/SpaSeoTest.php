<?php

namespace Tests\Feature;

use App\Models\Galeria\Album;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpaSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_spa_renderiza_metadatos_generales(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<meta property="og:title"', false)
            ->assertSee('Festividad del Señor de Huanca VMT');
    }

    public function test_spa_renderiza_metadatos_de_album_publicado(): void
    {
        Album::query()->create([
            'titulo' => 'Álbum central',
            'slug' => 'album-central',
            'descripcion' => 'Fotografías del día central de la festividad.',
            'publicado' => true,
        ]);

        $this->get('/galeria/album-central')
            ->assertOk()
            ->assertSee('Álbum central | Festividad del Señor de Huanca VMT')
            ->assertSee('Fotografías del día central de la festividad.');
    }
}
