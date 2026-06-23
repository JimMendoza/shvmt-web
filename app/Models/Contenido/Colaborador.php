<?php

namespace App\Models\Contenido;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $table = 'contenido.colaboradores';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'imagen',
        'orden',
        'publicado',
    ];

    protected function casts(): array
    {
        return [
            'publicado' => 'boolean',
        ];
    }
}
