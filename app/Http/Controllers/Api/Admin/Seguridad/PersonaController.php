<?php

namespace App\Http\Controllers\Api\Admin\Seguridad;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Seguridad\Persona;

class PersonaController extends CrudAdminController
{
    protected string $modelo = Persona::class;

    protected array $relaciones = ['sexo', 'tipoDocumento', 'distrito.provincia.departamento', 'estado'];
}
