<?php

namespace App\Models\Contenido;

use Illuminate\Database\Eloquent\Model;

class EntradaHistorica extends Model
{
    protected $table = 'contenido.entradas_historicas';

    protected $fillable = [
        'anio',
        'titulo',
        'descripcion',
        'mayordomos',
        'imagen_portada',
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
