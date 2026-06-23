<?php

namespace Database\Seeders;

use App\Models\Seguridad\Permiso;
use App\Models\Seguridad\Rol;
use App\Models\Seguridad\Usuario;
use Illuminate\Database\Seeder;

class SeguridadSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = collect([
            ['nombre' => 'Ver panel', 'codigo' => 'dashboard.ver', 'modulo' => 'dashboard'],
            ['nombre' => 'Ver configuración', 'codigo' => 'configuracion.ver', 'modulo' => 'configuracion'],
            ['nombre' => 'Editar configuración', 'codigo' => 'configuracion.editar', 'modulo' => 'configuracion'],
            ['nombre' => 'Administrar historia', 'codigo' => 'historia.administrar', 'modulo' => 'historia'],
            ['nombre' => 'Administrar mayordomía', 'codigo' => 'mayordomia.administrar', 'modulo' => 'mayordomia'],
            ['nombre' => 'Administrar programa', 'codigo' => 'programa.administrar', 'modulo' => 'programa'],
            ['nombre' => 'Ver galería', 'codigo' => 'galeria.ver', 'modulo' => 'galeria'],
            ['nombre' => 'Administrar galería', 'codigo' => 'galeria.administrar', 'modulo' => 'galeria'],
            ['nombre' => 'Administrar videos', 'codigo' => 'videos.administrar', 'modulo' => 'videos'],
            ['nombre' => 'Administrar comunicados', 'codigo' => 'comunicados.administrar', 'modulo' => 'comunicados'],
            ['nombre' => 'Administrar ubicaciones', 'codigo' => 'ubicaciones.administrar', 'modulo' => 'ubicaciones'],
            ['nombre' => 'Administrar colaboradores', 'codigo' => 'colaboradores.administrar', 'modulo' => 'colaboradores'],
            ['nombre' => 'Administrar archivo histórico', 'codigo' => 'archivo_historico.administrar', 'modulo' => 'archivo_historico'],
            ['nombre' => 'Ver usuarios', 'codigo' => 'seguridad.usuarios.ver', 'modulo' => 'seguridad'],
            ['nombre' => 'Administrar usuarios', 'codigo' => 'seguridad.usuarios.administrar', 'modulo' => 'seguridad'],
            ['nombre' => 'Ver roles', 'codigo' => 'seguridad.roles.ver', 'modulo' => 'seguridad'],
            ['nombre' => 'Administrar roles', 'codigo' => 'seguridad.roles.administrar', 'modulo' => 'seguridad'],
            ['nombre' => 'Asignar permisos', 'codigo' => 'seguridad.roles.asignar_permisos', 'modulo' => 'seguridad'],
        ])->map(fn (array $datos) => Permiso::query()->updateOrCreate(
            ['codigo' => $datos['codigo']],
            $datos,
        ));

        $administrador = Rol::query()->updateOrCreate(
            ['nombre' => 'admin'],
            ['descripcion' => 'Acceso completo al sistema', 'activo' => true],
        );
        $editor = Rol::query()->updateOrCreate(
            ['nombre' => 'editor'],
            ['descripcion' => 'Administración del contenido del sitio', 'activo' => true],
        );
        $fotografo = Rol::query()->updateOrCreate(
            ['nombre' => 'photographer'],
            ['descripcion' => 'Administración de álbumes y fotografías', 'activo' => true],
        );

        $administrador->permisos()->sync($permisos->pluck('id'));
        $editor->permisos()->sync($permisos
            ->reject(fn (Permiso $permiso) => $permiso->modulo === 'seguridad')
            ->pluck('id'));
        $fotografo->permisos()->sync($permisos
            ->whereIn('codigo', ['dashboard.ver', 'galeria.ver', 'galeria.administrar'])
            ->pluck('id'));

        $usuario = Usuario::query()->updateOrCreate(
            ['correo' => config('administracion.correo')],
            [
                'nombre' => config('administracion.nombre'),
                'contrasena' => config('administracion.contrasena'),
                'activo' => true,
                'debe_cambiar_contrasena' => true,
            ],
        );

        $usuario->roles()->sync([$administrador->id]);
    }
}
