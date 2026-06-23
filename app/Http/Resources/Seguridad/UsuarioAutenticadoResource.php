<?php

namespace App\Http\Resources\Seguridad;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioAutenticadoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'correo' => $this->correo,
            'debe_cambiar_contrasena' => $this->debe_cambiar_contrasena,
            'roles' => $this->roles->pluck('nombre')->values(),
            'permisos' => $this->roles
                ->flatMap->permisos
                ->pluck('codigo')
                ->unique()
                ->values(),
        ];
    }
}
