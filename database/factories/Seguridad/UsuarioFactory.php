<?php

namespace Database\Factories\Seguridad;

use App\Models\Seguridad\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'correo' => fake()->unique()->safeEmail(),
            'correo_verificado_en' => now(),
            'contrasena' => 'password',
            'activo' => true,
            'debe_cambiar_contrasena' => false,
            'remember_token' => Str::random(10),
        ];
    }
}
