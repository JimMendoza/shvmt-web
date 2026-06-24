<?php

namespace App\Http\Requests\Autenticacion;

use Illuminate\Foundation\Http\FormRequest;

class IniciarSesionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required_without:correo', 'string'],
            'correo' => ['required_without:login', 'string'],
            'contrasena' => ['required', 'string'],
        ];
    }
}
