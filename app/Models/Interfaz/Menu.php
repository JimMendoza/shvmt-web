<?php

namespace App\Models\Interfaz;

use App\Models\Catalogos\Estado;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'interfaz.menus';

    protected $fillable = [
        'titulo',
        'icono',
        'orden',
        'estado_id',
    ];

    public function items()
    {
        return $this->hasMany(MenuItem::class, 'menu_id')->orderBy('orden')->orderBy('id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
