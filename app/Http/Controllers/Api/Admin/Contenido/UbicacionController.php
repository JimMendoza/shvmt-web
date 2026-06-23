<?php

namespace App\Http\Controllers\Api\Admin\Contenido;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Contenido\Ubicacion;
use Illuminate\Database\Eloquent\Builder;

class UbicacionController extends CrudAdminController
{
    protected string $modelo = Ubicacion::class;

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderBy('orden')->orderBy('id');
    }
}
