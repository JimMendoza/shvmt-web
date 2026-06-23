<?php

namespace App\Models\Galeria;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'galeria.albumes';

    protected $fillable = [
        'titulo',
        'slug',
        'descripcion',
        'anio',
        'foto_portada_id',
        'orden',
        'publicado',
    ];

    public function fotos()
    {
        return $this->hasMany(Foto::class, 'album_id')->orderBy('orden');
    }

    public function portada()
    {
        return $this->belongsTo(Foto::class, 'foto_portada_id');
    }

    protected function casts(): array
    {
        return [
            'publicado' => 'boolean',
        ];
    }
}
