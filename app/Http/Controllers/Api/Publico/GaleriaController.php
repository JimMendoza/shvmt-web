<?php

namespace App\Http\Controllers\Api\Publico;

use App\Http\Controllers\Controller;
use App\Models\Galeria\Album;

class GaleriaController extends Controller
{
    public function albumes()
    {
        return Album::query()
            ->where('publicado', true)
            ->with('portada')
            ->orderByDesc('anio')
            ->orderBy('orden')
            ->get();
    }

    public function album(string $slug)
    {
        return Album::query()
            ->where('publicado', true)
            ->where('slug', $slug)
            ->with(['fotos' => fn ($consulta) => $consulta
                ->where('publicado', true)
                ->orderBy('orden')])
            ->firstOrFail();
    }
}
