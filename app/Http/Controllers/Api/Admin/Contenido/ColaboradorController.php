<?php

namespace App\Http\Controllers\Api\Admin\Contenido;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Contenido\Colaborador;
use Illuminate\Database\Eloquent\Builder;

class ColaboradorController extends CrudAdminController
{
    protected string $modelo = Colaborador::class;

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderBy('orden')->orderBy('id');
    }
}
