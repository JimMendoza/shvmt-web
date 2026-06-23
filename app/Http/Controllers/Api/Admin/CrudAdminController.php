<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CrudAdminRequest;
use Illuminate\Database\Eloquent\Builder;

abstract class CrudAdminController extends Controller
{
    protected string $modelo;

    protected array $relaciones = [];

    public function index()
    {
        return $this->consultaBase()->get();
    }

    public function store(CrudAdminRequest $request)
    {
        return $this->modelo::query()->create($request->all());
    }

    public function show(int $id)
    {
        return $this->consultaBase()->findOrFail($id);
    }

    public function update(CrudAdminRequest $request, int $id)
    {
        $registro = $this->modelo::query()->findOrFail($id);
        $registro->update($request->all());

        return $registro->fresh($this->relaciones);
    }

    public function destroy(int $id)
    {
        $this->modelo::query()->findOrFail($id)->delete();

        return response()->noContent();
    }

    protected function consultaBase(): Builder
    {
        return $this->ordenar($this->modelo::query()->with($this->relaciones));
    }

    protected function ordenar(Builder $consulta): Builder
    {
        return $consulta->orderBy('id');
    }
}
