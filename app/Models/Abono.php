<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Abono extends Model
{
    use HasUuids;

    protected $table = 'abonos';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'fecha',
        'abonado',
        'edad',
        'telefono',
        'cuenta_bancaria',
        'tipo',
        'asiento',
        'precio',
    ];

    // Relación con TipoAbono
    public function tipoAbono(): BelongsTo
    {
        return $this->belongsTo(TipoAbono::class, 'tipo');
    }

    // Lógica de negocio

    public function getIconoTipo(): string
    {
        return match ($this->tipoAbono->descripcion) {
            'Tribuna'     => 'oro.png',
            'Preferencia' => 'plata.png',
            'Fondo'       => 'bronce.png',
            default       => 'default.png',
        };
    }

    public function getTipoEspecial(): string
    {
        if ($this->edad < 12) return "Niño/a";
        if ($this->edad > 65) return "Jubilado/a";
        return "—";
    }

    // Genera un código de asiento único con reintentos
    public static function generarAsientoUnico(int $intentos = 5): ?string
    {
        for ($i = 0; $i < $intentos; $i++) {
            $sector        = rand(1, 5);
            $bloque        = rand(1, 5);
            $fila          = rand(0, 29);
            $asientos_max  = 140 + (2 * $fila);
            $asiento       = rand(0, $asientos_max - 1);

            $codigo = sprintf("%dB%d/F%02d-A%03d", $sector, $bloque, $fila, $asiento);

            if (!self::where('asiento', $codigo)->exists()) {
                return $codigo;
            }
        }

        return null; // No se encontró asiento libre tras los intentos
    }
}