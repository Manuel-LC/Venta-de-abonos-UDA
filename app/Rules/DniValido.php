<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DniValido implements ValidationRule
{
    private const LETRAS = 'TRWAGMYFPDXBNJZSQVHLCKE';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Primero comprobamos el formato básico
        if (!preg_match('/^[0-9]{8}[A-Z]$/', strtoupper($value))) {
            $fail('El DNI no tiene el formato correcto (8 dígitos + letra mayúscula).');
            return;
        }

        $numero     = (int) substr($value, 0, 8);
        $letraInput = strtoupper(substr($value, -1));
        $letraReal  = self::LETRAS[$numero % 23];

        if ($letraInput !== $letraReal) {
            $fail("La letra del DNI no es correcta (debería ser «{$letraReal}»).");
        }
    }
}