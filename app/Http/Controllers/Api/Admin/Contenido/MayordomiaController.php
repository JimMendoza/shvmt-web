<?php

namespace App\Http\Controllers\Api\Admin\Contenido;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Contenido\Mayordomia;
use Illuminate\Database\Eloquent\Builder;

class MayordomiaController extends CrudAdminController
{
    protected string $modelo = Mayordomia::class;

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderByDesc('anio')->orderBy('id');
    }
}
