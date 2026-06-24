<?php

namespace App\Http\Controllers\Api\Admin\Interfaz;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Interfaz\MenuItem;
use Illuminate\Database\Eloquent\Builder;

class MenuItemController extends CrudAdminController
{
    protected string $modelo = MenuItem::class;

    protected array $relaciones = ['menu', 'padre'];

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderBy('menu_id')->orderBy('parent_id')->orderBy('orden')->orderBy('id');
    }
}
