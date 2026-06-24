<?php

namespace App\Http\Controllers\Api\Admin\Catalogos;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Catalogos\Distrito;

class DistritoController extends CrudAdminController
{
    protected string $modelo = Distrito::class;

    protected array $relaciones = ['provincia.departamento', 'estado'];
}
