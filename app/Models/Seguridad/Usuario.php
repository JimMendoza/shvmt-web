<?php

namespace App\Models\Seguridad;

use Database\Factories\Seguridad\UsuarioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    /** @use HasFactory<UsuarioFactory> */
    use HasFactory, Notifiable;

    protected $table = 'seguridad.usuarios';

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'activo',
        'debe_cambiar_contrasena',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    protected static function newFactory(): UsuarioFactory
    {
        return UsuarioFactory::new();
    }

    public function getAuthPasswordName(): string
    {
        return 'contrasena';
    }

    public function roles()
    {
        return $this->belongsToMany(
            Rol::class,
            'seguridad.rol_usuario',
            'usuario_id',
            'rol_id',
        )->withTimestamps();
    }

    public function tienePermiso(string $codigo): bool
    {
        return $this->roles()
            ->where('activo', true)
            ->whereHas('permisos', fn ($consulta) => $consulta->where('codigo', $codigo))
            ->exists();
    }

    public function esAdministrador(): bool
    {
        return $this->roles()->where('nombre', 'admin')->where('activo', true)->exists();
    }

    protected function casts(): array
    {
        return [
            'correo_verificado_en' => 'datetime',
            'contrasena' => 'hashed',
            'activo' => 'boolean',
            'debe_cambiar_contrasena' => 'boolean',
        ];
    }
}
