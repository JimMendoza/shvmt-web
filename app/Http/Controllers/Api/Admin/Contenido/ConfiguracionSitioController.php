<?php

namespace App\Http\Controllers\Api\Admin\Contenido;

use App\Http\Controllers\Api\Admin\CrudAdminController;
use App\Models\Contenido\ConfiguracionSitio;

class ConfiguracionSitioController extends CrudAdminController
{
    protected string $modelo = ConfiguracionSitio::class;
}
