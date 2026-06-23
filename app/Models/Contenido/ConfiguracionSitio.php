<?php

namespace App\Models\Contenido;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionSitio extends Model
{
    protected $table = 'contenido.configuraciones_sitio';

    protected $fillable = [
        'nombre_sitio',
        'subtitulo_sitio',
        'anio_principal',
        'fecha_principal',
        'titulo_portada',
        'subtitulo_portada',
        'imagen_portada',
        'video_portada',
        'logo',
        'color_primario',
        'color_secundario',
        'telefono_contacto',
        'correo_contacto',
        'url_facebook',
        'url_youtube',
        'url_tiktok',
        'url_instagram',
    ];

    protected function casts(): array
    {
        return [
            'fecha_principal' => 'date',
        ];
    }
}
