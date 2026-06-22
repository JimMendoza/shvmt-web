<?php

use Illuminate\Support\Facades\Route;

Route::get('/estado', fn () => [
    'aplicacion' => 'Festividad del Señor de Huanca VMT',
    'estado' => 'disponible',
]);
