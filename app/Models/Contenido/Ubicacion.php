<?php

namespace App\Models\Contenido;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'contenido.ubicaciones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'direccion',
        'url_mapa',
        'url_mapa_incrustado',
        'tipo',
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
