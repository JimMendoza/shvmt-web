<?php

namespace App\Models\Contenido;

use Illuminate\Database\Eloquent\Model;

class SeccionHistoria extends Model
{
    protected $table = 'contenido.secciones_historia';

    protected $fillable = [
        'titulo',
        'subtitulo',
        'contenido',
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
