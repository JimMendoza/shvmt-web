<?php

namespace App\Models\Seguridad;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'seguridad.roles';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(
            Usuario::class,
            'seguridad.rol_usuario',
            'rol_id',
            'usuario_id',
        )->withTimestamps();
    }

    public function permisos()
    {
        return $this->belongsToMany(
            Permiso::class,
            'seguridad.permiso_rol',
            'rol_id',
            'permiso_id',
        )->withTimestamps();
    }

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }
}
