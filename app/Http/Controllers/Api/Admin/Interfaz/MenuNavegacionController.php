<?php

namespace App\Http\Controllers\Api\Admin\Interfaz;

use App\Http\Controllers\Controller;
use App\Models\Interfaz\Menu;
use App\Models\Interfaz\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MenuNavegacionController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user()->load('roles.permisos');
        $permisos = $usuario->roles->flatMap->permisos->pluck('codigo')->unique();
        $esAdmin = $usuario->esAdministrador();

        $menus = Menu::query()
            ->whereHas('items')
            ->whereHas('estado', fn ($consulta) => $consulta->where('activo', true)->where('sigla', '!=', 'E'))
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        $items = MenuItem::query()
            ->whereIn('menu_id', $menus->pluck('id'))
            ->whereHas('estado', fn ($consulta) => $consulta->where('activo', true)->where('sigla', '!=', 'E'))
            ->when(! $esAdmin, function ($consulta) use ($permisos) {
                $consulta->where(function ($subconsulta) use ($permisos) {
                    $subconsulta->whereNull('permiso_codigo')
                        ->orWhereIn('permiso_codigo', $permisos);
                });
            })
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        $itemsPorMenu = $items->groupBy('menu_id');

        return $menus
            ->map(fn (Menu $menu) => $this->mapearMenu($menu, $itemsPorMenu->get($menu->id, collect())))
            ->filter()
            ->values();
    }

    private function mapearMenu(Menu $menu, Collection $items): ?array
    {
        $raices = $this->armarArbol($items);

        if (empty($raices)) {
            return null;
        }

        return [
            'id' => $menu->id,
            'title' => $menu->titulo,
            'icon' => $menu->icono,
            'children' => $raices,
        ];
    }

    private function armarArbol(Collection $items): array
    {
        $porId = $items->keyBy('id');
        $hijos = [];

        foreach ($items as $item) {
            if ($item->parent_id && $porId->has($item->parent_id)) {
                $hijos[$item->parent_id][] = $item;
            }
        }

        return $items
            ->filter(fn (MenuItem $item) => ! $item->parent_id || ! $porId->has($item->parent_id))
            ->map(fn (MenuItem $item) => $this->mapearItem($item, $hijos))
            ->filter()
            ->values()
            ->all();
    }

    private function mapearItem(MenuItem $item, array $hijos): ?array
    {
        $children = collect($hijos[$item->id] ?? [])
            ->map(fn (MenuItem $hijo) => $this->mapearItem($hijo, $hijos))
            ->filter()
            ->values()
            ->all();

        if ($item->tipo === 'GRUPO' && empty($children)) {
            return null;
        }

        $base = [
            'id' => $item->id,
            'tipo' => $item->tipo,
            'title' => $item->titulo,
            'icon' => $item->icono,
        ];

        if ($item->tipo === 'SEPARADOR') {
            return [...$base, 'heading' => $item->titulo];
        }

        if (! empty($children)) {
            return [...$base, 'children' => $children];
        }

        return [...$base, 'to' => $item->ruta];
    }
}
