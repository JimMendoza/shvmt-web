<?php

namespace App\Http\Controllers\Api\Admin\Seguridad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AsignarRolesRequest;
use App\Http\Requests\Admin\CrudAdminRequest;
use App\Models\Seguridad\Usuario;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::query()
            ->with(['persona', 'roles'])
            ->orderBy('nombre')
            ->get();
    }

    public function store(CrudAdminRequest $request)
    {
        $datos = $request->except('roles');
        $usuario = Usuario::query()->create($datos);

        if ($request->has('roles')) {
            $usuario->roles()->sync($request->input('roles', []));
        }

        return $usuario->load(['persona', 'roles']);
    }

    public function show(int $id)
    {
        return Usuario::query()->with(['persona', 'roles'])->findOrFail($id);
    }

    public function update(CrudAdminRequest $request, int $id)
    {
        $usuario = Usuario::query()->findOrFail($id);
        $datos = $request->except('roles');

        if (! $request->filled('contrasena')) {
            unset($datos['contrasena']);
        }

        $usuario->update($datos);

        if ($request->has('roles')) {
            $usuario->roles()->sync($request->input('roles', []));
        }

        return $usuario->fresh(['persona', 'roles']);
    }

    public function destroy(int $id)
    {
        Usuario::query()->findOrFail($id)->delete();

        return response()->noContent();
    }

    public function asignarRoles(AsignarRolesRequest $request, int $usuario)
    {
        $registro = Usuario::query()->findOrFail($usuario);
        $registro->roles()->sync($request->input('roles', []));

        return $registro->fresh(['persona', 'roles']);
    }
}
