<?php

namespace Tests\Feature\Admin;

use App\Models\Seguridad\Permiso;
use App\Models\Seguridad\Rol;
use App\Models\Seguridad\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrudAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_puede_crear_actualizar_y_eliminar_historia(): void
    {
        $this->actingAs($this->admin());

        $respuesta = $this->postJson('/api/admin/historia', [
            'titulo' => 'Historia inicial',
            'contenido' => 'Texto inicial',
            'orden' => 1,
            'publicado' => true,
        ])->assertCreated();

        $id = $respuesta->json('id');

        $this->putJson("/api/admin/historia/{$id}", [
            'titulo' => 'Historia actualizada',
            'contenido' => 'Texto actualizado',
            'orden' => 2,
            'publicado' => false,
        ])
            ->assertOk()
            ->assertJsonPath('titulo', 'Historia actualizada');

        $this->getJson('/api/admin/historia')
            ->assertOk()
            ->assertJsonFragment(['titulo' => 'Historia actualizada']);

        $this->deleteJson("/api/admin/historia/{$id}")->assertNoContent();
    }

    public function test_usuario_sin_permiso_no_administra_contenido(): void
    {
        $usuario = Usuario::factory()->create([
            'debe_cambiar_contrasena' => false,
        ]);

        $this->actingAs($usuario)
            ->getJson('/api/admin/historia')
            ->assertForbidden();
    }

    public function test_admin_asigna_roles_y_permisos(): void
    {
        $this->actingAs($this->admin());

        $usuario = Usuario::factory()->create();
        $rol = Rol::query()->create([
            'nombre' => 'contenido',
            'activo' => true,
        ]);
        $permiso = Permiso::query()->where('codigo', 'historia.administrar')->first();

        $this->putJson("/api/admin/usuarios/{$usuario->id}/roles", [
            'roles' => [$rol->id],
        ])
            ->assertOk()
            ->assertJsonPath('roles.0.id', $rol->id);

        $this->putJson("/api/admin/roles/{$rol->id}/permisos", [
            'permisos' => [$permiso->id],
        ])
            ->assertOk()
            ->assertJsonPath('permisos.0.id', $permiso->id);
    }

    public function test_admin_recibe_menu_desde_base_de_datos(): void
    {
        $this->actingAs($this->admin());

        $this->getJson('/api/admin/menu')
            ->assertOk()
            ->assertJsonFragment(['title' => 'Administración'])
            ->assertJsonFragment(['to' => '/admin/dashboard']);
    }

    public function test_admin_tiene_persona_relacionada(): void
    {
        $usuario = $this->admin();

        $this->assertNotNull($usuario->persona_id);
        $this->assertSame('Administrador General', $usuario->persona->nombre_completo);
    }

    private function admin(): Usuario
    {
        $this->seed();

        $usuario = Usuario::query()
            ->where('correo', config('administracion.correo'))
            ->firstOrFail();
        $usuario->forceFill(['debe_cambiar_contrasena' => false])->save();

        return $usuario;
    }
}
