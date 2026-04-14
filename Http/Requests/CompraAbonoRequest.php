<?php

namespace App\Http\Requests;

use App\Rules\DniValido;
use App\Rules\IbanValido;
use Illuminate\Foundation\Http\FormRequest;

class CompraAbonoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_apellidos'    => 'required|string|max:255',
            'dni_aficionado'      => ['required', new DniValido()],
            'fecha_nacimiento'    => 'required|date_format:d/m/Y|before:today',
            'telefono_aficionado' => ['required', 'regex:/^[0-9]{9}$/'],
            'cuenta_bancaria'     => ['required', new IbanValido()],
            'tipo_abono'          => 'required|exists:tipo_abonos,id',
            'acepto_terminos'     => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_apellidos.required'    => 'El nombre es obligatorio.',
            'fecha_nacimiento.required'    => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date_format' => 'La fecha debe tener el formato dd/mm/aaaa.',
            'fecha_nacimiento.before'      => 'La fecha debe ser anterior a hoy.',
            'telefono_aficionado.required' => 'El teléfono es obligatorio.',
            'telefono_aficionado.regex'    => 'El teléfono debe tener 9 dígitos.',
            'tipo_abono.required'          => 'Debe seleccionar un tipo de abono.',
            'tipo_abono.exists'            => 'El tipo de abono seleccionado no existe.',
            'acepto_terminos.accepted'     => 'Debe aceptar los términos y condiciones.',
        ];
    }
}