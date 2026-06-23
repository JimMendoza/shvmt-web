<?php

namespace App\Models\Galeria;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'galeria.fotos';

    protected $fillable = [
        'album_id',
        'titulo',
        'descripcion',
        'ruta_archivo',
        'ruta_miniatura',
        'ruta_mediana',
        'orden',
        'publicado',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    protected function casts(): array
    {
        return [
            'publicado' => 'boolean',
        ];
    }
}
