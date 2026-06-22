<?php

use Illuminate\Support\Facades\Route;

Route::view('/{ruta?}', 'aplicacion')
    ->where('ruta', '^(?!api|sanctum).*$');
