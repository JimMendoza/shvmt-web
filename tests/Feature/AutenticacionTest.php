<?php

namespace Tests\Feature;

use App\Models\Seguridad\Permiso;
use App\Models\Seguridad\Rol;
use App\Models\Seguridad\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutenticacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_activo_puede_iniciar_y_cerrar_sesion(): void
    {
        $usuario = Usuario::factory()->create([
            'correo' => 'admin@prueba.pe',
            'contrasena' => 'secreta123',
        ]);

        $respuesta = $this->postJson('/api/auth/login', [
            'correo' => 'admin@prueba.pe',
            'contrasena' => 'secreta123',
        ]);

        $respuesta
            ->assertOk()
            ->assertJsonPath('usuario.correo', 'admin@prueba.pe');
        $this->assertAuthenticatedAs($usuario, 'web');

        $this->postJson('/api/auth/logout')->assertOk();
        $this->assertGuest('web');
    }

    public function test_usuario_inactivo_no_puede_iniciar_sesion(): void
    {
        Usuario::factory()->create([
            'correo' => 'inactivo@prueba.pe',
            'contrasena' => 'secreta123',
            'activo' => false,
        ]);

        $this->postJson('/api/auth/login', [
            'correo' => 'inactivo@prueba.pe',
            'contrasena' => 'secreta123',
        ])->assertUnprocessable();

        $this->assertGuest();
    }

    public function test_panel_exige_autenticacion_y_cambio_inicial_de_contrasena(): void
    {
        $usuario = Usuario::factory()->create([
            'contrasena' => 'secreta123',
            'debe_cambiar_contrasena' => true,
        ]);
        $rol = Rol::query()->create(['nombre' => 'admin', 'activo' => true]);
        $usuario->roles()->attach($rol);

        $this->getJson('/api/admin/dashboard')->assertUnauthorized();

        $this->actingAs($usuario)
            ->getJson('/api/admin/dashboard')
            ->assertStatus(423);

        $this->patchJson('/api/auth/contrasena', [
            'contrasena_actual' => 'secreta123',
            'contrasena' => 'nueva-secreta123',
            'contrasena_confirmation' => 'nueva-secreta123',
        ])->assertOk();

        $this->getJson('/api/admin/dashboard')->assertOk();
    }

    public function test_rol_autoriza_mediante_permiso(): void
    {
        $usuario = Usuario::factory()->create();
        $rol = Rol::query()->create(['nombre' => 'editor', 'activo' => true]);
        $permiso = Permiso::query()->create([
            'nombre' => 'Ver panel',
            'codigo' => 'dashboard.ver',
            'modulo' => 'dashboard',
        ]);
        $rol->permisos()->attach($permiso);
        $usuario->roles()->attach($rol);

        $this->actingAs($usuario)
            ->getJson('/api/admin/dashboard')
            ->assertOk();
    }
}
