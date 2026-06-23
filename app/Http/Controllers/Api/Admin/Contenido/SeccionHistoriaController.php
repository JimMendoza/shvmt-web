<?php

namespace App\Http\Controllers\Api\Admin\Contenido;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Contenido\SeccionHistoria;
use Illuminate\Database\Eloquent\Builder;

class SeccionHistoriaController extends CrudAdminController
{
    protected string $modelo = SeccionHistoria::class;

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderBy('orden')->orderBy('id');
    }
}
