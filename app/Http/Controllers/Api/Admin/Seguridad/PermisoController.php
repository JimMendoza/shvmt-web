<?php

namespace App\Http\Controllers\Api\Admin\Seguridad;

use App\Http\Controllers\Controller;
use App\Models\Seguridad\Permiso;

class PermisoController extends Controller
{
    public function index()
    {
        return Permiso::query()
            ->orderBy('modulo')
            ->orderBy('nombre')
            ->get();
    }
}
