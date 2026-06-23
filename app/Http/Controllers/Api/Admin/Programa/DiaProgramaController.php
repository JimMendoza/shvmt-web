<?php

namespace App\Http\Controllers\Api\Admin\Programa;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Programa\DiaPrograma;
use Illuminate\Database\Eloquent\Builder;

class DiaProgramaController extends CrudAdminController
{
    protected string $modelo = DiaPrograma::class;

    protected array $relaciones = ['actividades'];

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderBy('fecha')->orderBy('orden')->orderBy('id');
    }
}
