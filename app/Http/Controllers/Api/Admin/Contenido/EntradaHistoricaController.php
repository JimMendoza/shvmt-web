<?php

namespace App\Http\Controllers\Api\Admin\Contenido;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Contenido\EntradaHistorica;
use Illuminate\Database\Eloquent\Builder;

class EntradaHistoricaController extends CrudAdminController
{
    protected string $modelo = EntradaHistorica::class;

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderByDesc('anio')->orderBy('orden')->orderBy('id');
    }
}
