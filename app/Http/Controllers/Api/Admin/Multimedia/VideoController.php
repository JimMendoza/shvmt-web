<?php

namespace App\Http\Controllers\Api\Admin\Multimedia;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Multimedia\Video;
use Illuminate\Database\Eloquent\Builder;

class VideoController extends CrudAdminController
{
    protected string $modelo = Video::class;

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderByDesc('anio')->orderBy('orden')->orderBy('id');
    }
}
