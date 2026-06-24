<?php

namespace App\Http\Controllers\Api\Admin\Catalogos;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Catalogos\Sexo;

class SexoController extends CrudAdminController
{
    protected string $modelo = Sexo::class;

    protected array $relaciones = ['estado'];
}
