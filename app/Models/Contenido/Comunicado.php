<?php

namespace App\Models\Contenido;

use Illuminate\Database\Eloquent\Model;

class Comunicado extends Model
{
    protected $table = 'contenido.comunicados';

    protected $fillable = [
        'titulo',
        'slug',
        'contenido',
        'imagen',
        'destacado',
        'publicado',
        'publicado_en',
    ];

    protected function casts(): array
    {
        return [
            'destacado' => 'boolean',
            'publicado' => 'boolean',
            'publicado_en' => 'datetime',
        ];
    }
}
