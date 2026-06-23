<?php

namespace App\Models\Contenido;

use Illuminate\Database\Eloquent\Model;

class Mayordomia extends Model
{
    protected $table = 'contenido.mayordomias';

    protected $fillable = [
        'anio',
        'titulo',
        'nombre_familia',
        'nombre_mayordoma_principal',
        'mensaje',
        'imagen',
        'actual',
        'publicado',
    ];

    protected function casts(): array
    {
        return [
            'actual' => 'boolean',
            'publicado' => 'boolean',
        ];
    }
}
