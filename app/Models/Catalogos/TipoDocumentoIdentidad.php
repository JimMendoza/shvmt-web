<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class TipoDocumentoIdentidad extends Model
{
    protected $table = 'catalogos.tipos_documento_identidad';

    protected $fillable = [
        'nombre',
        'abreviatura',
        'caracteres_max',
        'estado_id',
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
