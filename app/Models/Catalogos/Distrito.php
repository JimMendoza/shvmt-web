<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'catalogos.distritos';

    protected $fillable = [
        'provincia_id',
        'codigo',
        'nombre',
        'capital',
        'ubigeo_dni',
        'ubigeo_inei',
        'estado_id',
    ];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
