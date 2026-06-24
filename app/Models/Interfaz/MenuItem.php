<?php

namespace App\Models\Interfaz;

use App\Models\Catalogos\Estado;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'interfaz.menu_items';

    protected $fillable = [
        'menu_id',
        'parent_id',
        'tipo',
        'titulo',
        'icono',
        'ruta',
        'orden',
        'permiso_codigo',
        'estado_id',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function padre()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function hijos()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('orden')->orderBy('id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
