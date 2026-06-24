<?php

namespace App\Http\Controllers\Api\Autenticacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Autenticacion\CambiarContrasenaRequest;
use App\Http\Requests\Autenticacion\IniciarSesionRequest;
use App\Http\Resources\Seguridad\UsuarioAutenticadoResource;
use App\Models\Seguridad\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AutenticacionController extends Controller
{
    public function iniciarSesion(IniciarSesionRequest $request): JsonResponse
    {
        $datos = $request->validated();
        $login = $datos['login'] ?? $datos['correo'];
        $usuario = Usuario::query()
            ->whereRaw('lower(correo) = lower(?)', [$login])
            ->orWhereRaw('lower(username) = lower(?)', [$login])
            ->first();

        if (! $usuario || ! Hash::check($datos['contrasena'], $usuario->contrasena)) {
            throw ValidationException::withMessages([
                'login' => ['Las credenciales no son válidas.'],
            ]);
        }

        if (! $usuario->activo) {
            throw ValidationException::withMessages([
                'login' => ['El usuario está inactivo.'],
            ]);
        }

        Auth::guard('web')->login($usuario);
        $request->session()->regenerate();

        return response()->json([
            'usuario' => new UsuarioAutenticadoResource($usuario->load(['persona', 'roles.permisos'])),
        ]);
    }

    public function usuarioActual(Request $request): UsuarioAutenticadoResource
    {
        return new UsuarioAutenticadoResource(
            $request->user()->load(['persona', 'roles.permisos']),
        );
    }

    public function cambiarContrasena(CambiarContrasenaRequest $request): JsonResponse
    {
        $usuario = $request->user();
        $datos = $request->validated();

        if (! Hash::check($datos['contrasena_actual'], $usuario->contrasena)) {
            throw ValidationException::withMessages([
                'contrasena_actual' => ['La contraseña actual no es correcta.'],
            ]);
        }

        $usuario->update([
            'contrasena' => $datos['contrasena'],
            'debe_cambiar_contrasena' => false,
        ]);

        return response()->json(['mensaje' => 'Contraseña actualizada correctamente.']);
    }

    public function cerrarSesion(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['mensaje' => 'Sesión cerrada correctamente.']);
    }
}
