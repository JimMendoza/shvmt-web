<?php

namespace App\Http\Controllers\Api\Publico;

use App\Http\Controllers\Controller;
use App\Models\Contenido\Colaborador;
use App\Models\Contenido\Comunicado;
use App\Models\Contenido\ConfiguracionSitio;
use App\Models\Contenido\EntradaHistorica;
use App\Models\Contenido\Mayordomia;
use App\Models\Contenido\SeccionHistoria;
use App\Models\Contenido\Ubicacion;

class ContenidoController extends Controller
{
    public function configuracion()
    {
        return ConfiguracionSitio::query()->first();
    }

    public function historia()
    {
        return SeccionHistoria::query()
            ->where('publicado', true)
            ->orderBy('orden')
            ->get();
    }

    public function mayordomia()
    {
        return Mayordomia::query()
            ->where('publicado', true)
            ->where('actual', true)
            ->latest('anio')
            ->first();
    }

    public function comunicados()
    {
        return Comunicado::query()
            ->where('publicado', true)
            ->orderByDesc('destacado')
            ->orderByDesc('publicado_en')
            ->get();
    }

    public function comunicado(string $slug)
    {
        return Comunicado::query()
            ->where('publicado', true)
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function ubicaciones()
    {
        return Ubicacion::query()
            ->where('publicado', true)
            ->orderBy('orden')
            ->get();
    }

    public function colaboradores()
    {
        return Colaborador::query()
            ->where('publicado', true)
            ->orderBy('orden')
            ->get();
    }

    public function archivoHistorico()
    {
        return EntradaHistorica::query()
            ->where('publicado', true)
            ->orderByDesc('anio')
            ->orderBy('orden')
            ->get();
    }
}
