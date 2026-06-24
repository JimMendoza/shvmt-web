<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'catalogos.departamentos';

    protected $fillable = [
        'codigo',
        'nombre',
        'ubigeo_dni',
        'ubigeo_inei',
        'estado_id',
    ];

    public function provincias()
    {
        return $this->hasMany(Provincia::class, 'departamento_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
