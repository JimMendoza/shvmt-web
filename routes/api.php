<?php

use Illuminate\Support\Facades\Route;

Route::get('/estado', fn () => [
    'aplicacion' => 'Festividad del Señor de Huanca VMT',
    'estado' => 'disponible',
]);

require __DIR__.'/api/autenticacion.php';
require __DIR__.'/api/publico.php';
require __DIR__.'/api/admin.php';
