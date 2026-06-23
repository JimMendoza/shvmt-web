<?php

namespace App\Http\Controllers\Api\Admin\Galeria;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Galeria\Foto;
use Illuminate\Database\Eloquent\Builder;

class FotoController extends CrudAdminController
{
    protected string $modelo = Foto::class;

    protected array $relaciones = ['album'];

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderBy('album_id')->orderBy('orden')->orderBy('id');
    }
}
