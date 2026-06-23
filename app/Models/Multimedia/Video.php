<?php

namespace App\Models\Multimedia;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'multimedia.videos';

    protected $fillable = [
        'titulo',
        'slug',
        'descripcion',
        'url_video',
        'url_incrustado',
        'miniatura',
        'categoria',
        'anio',
        'orden',
        'destacado',
        'publicado',
    ];

    protected function casts(): array
    {
        return [
            'destacado' => 'boolean',
            'publicado' => 'boolean',
        ];
    }
}
