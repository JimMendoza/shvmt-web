<?php

namespace App\Http\Controllers\Api\Admin\Seguridad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AsignarPermisosRequest;
use App\Http\Requests\Admin\CrudAdminRequest;
use App\Models\Seguridad\Rol;

class RolController extends Controller
{
    public function index()
    {
        return Rol::query()
            ->with('permisos')
            ->orderBy('nombre')
            ->get();
    }

    public function store(CrudAdminRequest $request)
    {
        $rol = Rol::query()->create($request->except('permisos'));

        if ($request->has('permisos')) {
            $rol->permisos()->sync($request->input('permisos', []));
        }

        return $rol->load('permisos');
    }

    public function show(int $id)
    {
        return Rol::query()->with('permisos')->findOrFail($id);
    }

    public function update(CrudAdminRequest $request, int $id)
    {
        $rol = Rol::query()->findOrFail($id);
        $rol->update($request->except('permisos'));

        if ($request->has('permisos')) {
            $rol->permisos()->sync($request->input('permisos', []));
        }

        return $rol->fresh('permisos');
    }

    public function destroy(int $id)
    {
        Rol::query()->findOrFail($id)->delete();

        return response()->noContent();
    }

    public function asignarPermisos(AsignarPermisosRequest $request, int $rol)
    {
        $registro = Rol::query()->findOrFail($rol);
        $registro->permisos()->sync($request->input('permisos', []));

        return $registro->fresh('permisos');
    }
}
