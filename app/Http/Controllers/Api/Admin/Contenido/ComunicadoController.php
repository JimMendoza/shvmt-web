<?php

namespace App\Http\Controllers\Api\Admin\Contenido;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Contenido\Comunicado;
use Illuminate\Database\Eloquent\Builder;

class ComunicadoController extends CrudAdminController
{
    protected string $modelo = Comunicado::class;

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderByDesc('publicado_en')->orderBy('id');
    }
}
