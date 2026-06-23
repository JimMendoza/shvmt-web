<?php

namespace App\Models\Programa;

use Illuminate\Database\Eloquent\Model;

class ActividadPrograma extends Model
{
    protected $table = 'programa.actividades_programa';

    protected $fillable = [
        'dia_programa_id',
        'titulo',
        'descripcion',
        'hora_inicio',
        'hora_fin',
        'nombre_lugar',
        'direccion',
        'url_mapa',
        'url_mapa_incrustado',
        'responsable',
        'orden',
        'publicado',
    ];

    public function dia()
    {
        return $this->belongsTo(DiaPrograma::class, 'dia_programa_id');
    }

    protected function casts(): array
    {
        return [
            'publicado' => 'boolean',
        ];
    }
}
