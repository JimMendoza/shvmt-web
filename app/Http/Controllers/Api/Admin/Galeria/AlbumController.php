<?php

namespace App\Http\Controllers\Api\Admin\Galeria;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Galeria\Album;
use Illuminate\Database\Eloquent\Builder;

class AlbumController extends CrudAdminController
{
    protected string $modelo = Album::class;

    protected array $relaciones = ['portada'];

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderByDesc('anio')->orderBy('orden')->orderBy('id');
    }
}
