<?php

use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

Route::get('/{ruta?}', SpaController::class)
    ->where('ruta', '^(?!api|sanctum).*$');
