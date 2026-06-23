<?php

namespace App\Models\Seguridad;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'seguridad.permisos';

    protected $fillable = [
        'nombre',
        'codigo',
        'modulo',
    ];

    public function roles()
    {
        return $this->belongsToMany(
            Rol::class,
            'seguridad.permiso_rol',
            'permiso_id',
            'rol_id',
        )->withTimestamps();
    }
}
