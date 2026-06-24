<?php

namespace App\Http\Controllers\Api\Admin\Catalogos;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Catalogos\TipoDocumentoIdentidad;

class TipoDocumentoIdentidadController extends CrudAdminController
{
    protected string $modelo = TipoDocumentoIdentidad::class;

    protected array $relaciones = ['estado'];
}
