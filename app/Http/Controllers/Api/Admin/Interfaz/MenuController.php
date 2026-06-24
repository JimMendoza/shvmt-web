<?php

namespace App\Http\Controllers\Api\Admin\Interfaz;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Interfaz\Menu;
use Illuminate\Database\Eloquent\Builder;

class MenuController extends CrudAdminController
{
    protected string $modelo = Menu::class;

    protected array $relaciones = ['items'];

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderBy('orden')->orderBy('id');
    }
}
