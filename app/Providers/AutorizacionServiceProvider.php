<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AutorizacionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::before(function ($usuario, string $permiso) {
            if ($usuario->esAdministrador()) {
                return true;
            }

            return $usuario->tienePermiso($permiso) ?: null;
        });
    }
}
