<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'catalogos.provincias';

    protected $fillable = [
        'departamento_id',
        'codigo',
        'nombre',
        'ubigeo_dni',
        'ubigeo_inei',
        'estado_id',
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function distritos()
    {
        return $this->hasMany(Distrito::class, 'provincia_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
