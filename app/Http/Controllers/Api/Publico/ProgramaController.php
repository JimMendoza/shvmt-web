<?php

namespace App\Http\Controllers\Api\Publico;

use App\Http\Controllers\Controller;
use App\Models\Programa\DiaPrograma;

class ProgramaController extends Controller
{
    public function index()
    {
        return DiaPrograma::query()
            ->where('publicado', true)
            ->with(['actividades' => fn ($consulta) => $consulta
                ->where('publicado', true)
                ->orderBy('orden')])
            ->orderBy('fecha')
            ->orderBy('orden')
            ->get();
    }
}
