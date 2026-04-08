<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraAbonoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre_apellidos'    => 'required|string|max:255',
            'dni_aficionado'      => ['required', 'regex:/^[0-9]{8}[A-Z]$/'],
            'fecha_nacimiento'    => 'required|date|before:today',
            'telefono_aficionado' => ['required', 'regex:/^[0-9]{9}$/'],
            'cuenta_bancaria'     => ['required', 'regex:/^ES[0-9]{22}$/'],
            'tipo_abono'          => 'required|exists:tipo_abonos,id',
            'acepto_terminos'     => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_apellidos.required'    => 'El nombre es obligatorio.',
            'dni_aficionado.required'      => 'El DNI es obligatorio.',
            'dni_aficionado.regex'         => 'El DNI no es válido (8 dígitos + letra mayúscula).',
            'fecha_nacimiento.required'    => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before'      => 'La fecha debe ser anterior a hoy.',
            'telefono_aficionado.required' => 'El teléfono es obligatorio.',
            'telefono_aficionado.regex'    => 'El teléfono debe tener 9 dígitos.',
            'cuenta_bancaria.required'     => 'La cuenta bancaria es obligatoria.',
            'cuenta_bancaria.regex'        => 'La cuenta no es válida (ES + 22 dígitos).',
            'tipo_abono.required'          => 'Debe seleccionar un tipo de abono.',
            'tipo_abono.exists'            => 'El tipo de abono seleccionado no existe.',
            'acepto_terminos.accepted'     => 'Debe aceptar los términos y condiciones.',
        ];
    }
}
