<?php

namespace App\Models\Seguridad;

use App\Models\Catalogos\Distrito;
use App\Models\Catalogos\Estado;
use App\Models\Catalogos\Sexo;
use App\Models\Catalogos\TipoDocumentoIdentidad;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'seguridad.personas';

    protected $fillable = [
        'foto_path',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'tipo_documento_id',
        'numero_documento',
        'fecha_nacimiento',
        'sexo_id',
        'direccion',
        'correo',
        'telefono_movil',
        'distrito_id',
        'referencia',
        'estado_id',
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'persona_id');
    }

    public function sexo()
    {
        return $this->belongsTo(Sexo::class, 'sexo_id');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumentoIdentidad::class, 'tipo_documento_id');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}");
    }

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
        ];
    }
}
