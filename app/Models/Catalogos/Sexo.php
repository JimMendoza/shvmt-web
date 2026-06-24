<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $table = 'catalogos.sexos';

    protected $fillable = [
        'nombre',
        'estado_id',
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
