<?php

namespace App\Http\Controllers\Api\Admin\Programa;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Programa\ActividadPrograma;
use Illuminate\Database\Eloquent\Builder;

class ActividadProgramaController extends CrudAdminController
{
    protected string $modelo = ActividadPrograma::class;

    protected array $relaciones = ['dia'];

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderBy('dia_programa_id')->orderBy('orden')->orderBy('id');
    }
}
