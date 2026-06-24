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
        'persona_id',
        'username',
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

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
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

    public function nombreVisible(): string
    {
        return $this->persona?->nombre_completo ?: $this->nombre;
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
