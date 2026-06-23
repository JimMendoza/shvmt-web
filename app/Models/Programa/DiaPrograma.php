<?php

namespace App\Models\Programa;

use Illuminate\Database\Eloquent\Model;

class DiaPrograma extends Model
{
    protected $table = 'programa.dias_programa';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'orden',
        'publicado',
    ];

    public function actividades()
    {
        return $this->hasMany(ActividadPrograma::class, 'dia_programa_id')->orderBy('orden');
    }

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'publicado' => 'boolean',
        ];
    }
}
