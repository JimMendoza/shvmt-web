<?php

namespace App\Http\Controllers;

use App\Models\Contenido\Comunicado;
use App\Models\Contenido\ConfiguracionSitio;
use App\Models\Galeria\Album;
use App\Models\Multimedia\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpaController extends Controller
{
    public function __invoke(Request $request)
    {
        $metadatos = $this->metadatos($request);

        return view('aplicacion', compact('metadatos'));
    }

    private function metadatos(Request $request): array
    {
        $configuracion = ConfiguracionSitio::query()->first();
        $nombre = $configuracion?->nombre_sitio ?: 'Festividad del Señor de Huanca VMT';
        $descripcion = $configuracion?->subtitulo_sitio ?: 'Sitio oficial de la Festividad del Señor de Huanca en Villa María del Triunfo.';
        $imagen = $configuracion?->imagen_portada;
        $ruta = trim($request->path(), '/');

        $metadatos = [
            'titulo' => $nombre,
            'descripcion' => $descripcion,
            'imagen' => $imagen,
            'url' => $request->fullUrl(),
            'tipo' => 'website',
        ];

        if (Str::startsWith($ruta, 'galeria/')) {
            return $this->metadatosModelo(
                Album::query()->where('publicado', true)->where('slug', Str::after($ruta, 'galeria/'))->first(),
                $metadatos,
            );
        }

        if (Str::startsWith($ruta, 'videos/')) {
            return $this->metadatosModelo(
                Video::query()->where('publicado', true)->where('slug', Str::after($ruta, 'videos/'))->first(),
                $metadatos,
                'miniatura',
            );
        }

        if (Str::startsWith($ruta, 'comunicados/')) {
            return $this->metadatosModelo(
                Comunicado::query()->where('publicado', true)->where('slug', Str::after($ruta, 'comunicados/'))->first(),
                $metadatos,
                'imagen',
            );
        }

        $titulos = [
            'historia' => 'Historia',
            'mayordomia' => 'Mayordomía',
            'programa' => 'Programa oficial',
            'galeria' => 'Galería',
            'videos' => 'Videos',
            'ubicacion' => 'Ubicación',
            'archivo-historico' => 'Archivo histórico',
        ];

        if (isset($titulos[$ruta])) {
            $metadatos['titulo'] = $titulos[$ruta].' | '.$nombre;
        }

        return $metadatos;
    }

    private function metadatosModelo($modelo, array $metadatos, ?string $campoImagen = null): array
    {
        if (! $modelo) {
            return $metadatos;
        }

        $metadatos['titulo'] = $modelo->titulo.' | '.$metadatos['titulo'];
        $metadatos['descripcion'] = Str::limit(strip_tags($modelo->descripcion ?? $modelo->contenido ?? $metadatos['descripcion']), 155);

        if ($campoImagen && $modelo->{$campoImagen}) {
            $metadatos['imagen'] = $modelo->{$campoImagen};
        }

        return $metadatos;
    }
}
