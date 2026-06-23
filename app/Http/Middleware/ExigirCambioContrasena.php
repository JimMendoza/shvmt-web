<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExigirCambioContrasena
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->debe_cambiar_contrasena) {
            return response()->json([
                'mensaje' => 'Debes cambiar tu contraseña antes de continuar.',
            ], 423);
        }

        return $next($request);
    }
}
