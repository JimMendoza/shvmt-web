<?php

namespace App\Http\Controllers\Api\Admin\Catalogos;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Catalogos\Departamento;

class DepartamentoController extends CrudAdminController
{
    protected string $modelo = Departamento::class;

    protected array $relaciones = ['estado'];
}
