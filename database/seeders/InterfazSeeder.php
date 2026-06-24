<?php

namespace Database\Seeders;

use App\Models\Interfaz\Menu;
use App\Models\Interfaz\MenuItem;
use Illuminate\Database\Seeder;

class InterfazSeeder extends Seeder
{
    public function run(): void
    {
        $administracion = $this->menu('Administración', 'pi pi-cog', 1);
        $contenido = $this->menu('Contenido', 'pi pi-images', 2);
        $catalogos = $this->menu('Catálogos', 'pi pi-database', 3);
        $seguridad = $this->menu('Seguridad', 'pi pi-shield', 4);

        $this->item($administracion, null, 'LINK', 'Panel', 'pi pi-home', '/admin/dashboard', 1, 'dashboard.ver');
        $this->item($administracion, null, 'LINK', 'Configuración', 'pi pi-cog', '/admin/configuracion-sitio', 2, 'configuracion.editar');

        $this->item($contenido, null, 'LINK', 'Historia', 'pi pi-book', '/admin/historia', 1, 'historia.administrar');
        $this->item($contenido, null, 'LINK', 'Mayordomías', 'pi pi-users', '/admin/mayordomias', 2, 'mayordomia.administrar');
        $programa = $this->item($contenido, null, 'GRUPO', 'Programa', 'pi pi-calendar', null, 3, 'programa.administrar');
        $this->item($contenido, $programa->id, 'LINK', 'Días', 'pi pi-calendar', '/admin/dias-programa', 1, 'programa.administrar');
        $this->item($contenido, $programa->id, 'LINK', 'Actividades', 'pi pi-clock', '/admin/actividades-programa', 2, 'programa.administrar');
        $galeria = $this->item($contenido, null, 'GRUPO', 'Galería', 'pi pi-images', null, 4, 'galeria.administrar');
        $this->item($contenido, $galeria->id, 'LINK', 'Álbumes', 'pi pi-images', '/admin/albumes', 1, 'galeria.administrar');
        $this->item($contenido, $galeria->id, 'LINK', 'Fotos', 'pi pi-image', '/admin/fotos', 2, 'galeria.administrar');
        $this->item($contenido, null, 'LINK', 'Videos', 'pi pi-video', '/admin/videos', 5, 'videos.administrar');
        $this->item($contenido, null, 'LINK', 'Comunicados', 'pi pi-megaphone', '/admin/comunicados', 6, 'comunicados.administrar');
        $this->item($contenido, null, 'LINK', 'Ubicaciones', 'pi pi-map-marker', '/admin/ubicaciones', 7, 'ubicaciones.administrar');
        $this->item($contenido, null, 'LINK', 'Colaboradores', 'pi pi-heart', '/admin/colaboradores', 8, 'colaboradores.administrar');
        $this->item($contenido, null, 'LINK', 'Archivo histórico', 'pi pi-folder', '/admin/archivo-historico', 9, 'archivo_historico.administrar');

        $this->item($catalogos, null, 'LINK', 'Sexos', 'pi pi-id-card', '/admin/catalogos/sexos', 1, 'catalogos.sexos.administrar');
        $this->item($catalogos, null, 'LINK', 'Tipos de documento', 'pi pi-id-card', '/admin/catalogos/tipos-documento-identidad', 2, 'catalogos.tipos_documento.administrar');
        $ubigeos = $this->item($catalogos, null, 'GRUPO', 'Ubigeos', 'pi pi-map', null, 3, 'catalogos.ubigeos.administrar');
        $this->item($catalogos, $ubigeos->id, 'LINK', 'Departamentos', 'pi pi-map', '/admin/catalogos/departamentos', 1, 'catalogos.departamentos.administrar');
        $this->item($catalogos, $ubigeos->id, 'LINK', 'Provincias', 'pi pi-map-marker', '/admin/catalogos/provincias', 2, 'catalogos.provincias.administrar');
        $this->item($catalogos, $ubigeos->id, 'LINK', 'Distritos', 'pi pi-compass', '/admin/catalogos/distritos', 3, 'catalogos.distritos.administrar');

        $this->item($seguridad, null, 'LINK', 'Personas', 'pi pi-id-card', '/admin/personas', 1, 'seguridad.personas.administrar');
        $this->item($seguridad, null, 'LINK', 'Usuarios', 'pi pi-users', '/admin/seguridad', 2, 'seguridad.usuarios.administrar');
        $this->item($seguridad, null, 'LINK', 'Roles y permisos', 'pi pi-key', '/admin/seguridad', 3, 'seguridad.roles.administrar');
        $this->item($seguridad, null, 'LINK', 'Menús', 'pi pi-bars', '/admin/interfaz/menus', 4, 'interfaz.menus.administrar');
        $this->item($seguridad, null, 'LINK', 'Items de menú', 'pi pi-list', '/admin/interfaz/menu-items', 5, 'interfaz.menu_items.administrar');
    }

    private function menu(string $titulo, string $icono, int $orden): Menu
    {
        return Menu::query()->updateOrCreate(
            ['titulo' => $titulo],
            ['icono' => $icono, 'orden' => $orden, 'estado_id' => 1],
        );
    }

    private function item(Menu $menu, ?int $padreId, string $tipo, string $titulo, string $icono, ?string $ruta, int $orden, ?string $permiso): MenuItem
    {
        return MenuItem::query()->updateOrCreate(
            ['menu_id' => $menu->id, 'parent_id' => $padreId, 'titulo' => $titulo],
            [
                'tipo' => $tipo,
                'icono' => $icono,
                'ruta' => $ruta,
                'orden' => $orden,
                'permiso_codigo' => $permiso,
                'estado_id' => 1,
            ],
        );
    }
}
