<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IbanValido implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $iban = strtoupper(preg_replace('/\s+/', '', $value));

        // Formato: "ES" seguido de exactamente 22 dígitos
        if (!preg_match('/^ES[0-9]{22}$/', $iban)) {
            $fail('La cuenta bancaria no es válida (formato: ES + 22 dígitos).');
            return;
        }

        // Reordenar: mover los 4 primeros chars al final
        $reordenado = substr($iban, 4) . substr($iban, 0, 4);

        // Convertir letras a números (A=10 … Z=35)
        $numerico = '';
        foreach (str_split($reordenado) as $char) {
            $numerico .= ctype_alpha($char)
                ? (string)(ord($char) - 55)
                : $char;
        }

        // Validar mod-97 (usa bcmod para números grandes)
        if (bcmod($numerico, '97') !== '1') {
            $fail('El número de cuenta bancaria (IBAN) no supera la verificación de integridad.');
        }
    }
}