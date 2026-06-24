<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'catalogos.estados';

    protected $fillable = [
        'nombre',
        'sigla',
        'descripcion',
        'tipo',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }
}
