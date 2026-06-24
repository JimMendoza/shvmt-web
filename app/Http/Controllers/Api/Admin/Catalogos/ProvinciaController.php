<?php

namespace App\Http\Controllers\Api\Admin\Catalogos;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Catalogos\Provincia;

class ProvinciaController extends CrudAdminController
{
    protected string $modelo = Provincia::class;

    protected array $relaciones = ['departamento', 'estado'];
}
