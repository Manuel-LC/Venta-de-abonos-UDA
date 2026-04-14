<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Abono;
use App\Models\TipoAbono;
use App\Rules\DniValido;
use App\Rules\IbanValido;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AbonosApiController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | GET /api/tipos-abono
    | Devuelve todos los tipos de abono con id, descripción y precio.
    |----------------------------------------------------------------------
    */
    public function tiposAbono(): JsonResponse
    {
        $tipos = TipoAbono::all(['id', 'descripcion', 'precio']);

        return response()->json([
            'datos' => $tipos,
        ]);
    }

    /*
    |----------------------------------------------------------------------
    | POST /api/abonos
    | Valida los datos, calcula el precio y crea el abono.
    |
    | Body JSON esperado:
    |   nombre_apellidos  (string)
    |   dni_aficionado    (string, formato DNI español)
    |   fecha_nacimiento  (string, formato dd/mm/aaaa)
    |   telefono_aficionado (string, 9 dígitos)
    |   cuenta_bancaria   (string, IBAN español)
    |   tipo_abono        (string, id existente en tipo_abonos)
    |----------------------------------------------------------------------
    */
    public function store(Request $request): JsonResponse
    {
        // ── Validación ────────────────────────────────────────────────────
        $validator = Validator::make($request->all(), [
            'nombre_apellidos'    => 'required|string|max:255',
            'dni_aficionado'      => ['required', new DniValido()],
            'fecha_nacimiento'    => 'required|date_format:d/m/Y|before:today',
            'telefono_aficionado' => ['required', 'regex:/^[0-9]{9}$/'],
            'cuenta_bancaria'     => ['required', new IbanValido()],
            'tipo_abono'          => 'required|exists:tipo_abonos,id',
        ], [
            'nombre_apellidos.required'    => 'El nombre es obligatorio.',
            'fecha_nacimiento.required'    => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date_format' => 'La fecha debe tener el formato dd/mm/aaaa.',
            'fecha_nacimiento.before'      => 'La fecha debe ser anterior a hoy.',
            'telefono_aficionado.required' => 'El teléfono es obligatorio.',
            'telefono_aficionado.regex'    => 'El teléfono debe tener 9 dígitos.',
            'tipo_abono.required'          => 'Debe seleccionar un tipo de abono.',
            'tipo_abono.exists'            => 'El tipo de abono seleccionado no existe.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'  => 'Datos no válidos.',
                'errores' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validated = $validator->validated();

        // ── Cálculo de edad y precio ──────────────────────────────────────
        $edad = Carbon::createFromFormat('d/m/Y', $validated['fecha_nacimiento'])->age;

        $tipoAbono  = TipoAbono::findOrFail($validated['tipo_abono']);
        $precioBase = $tipoAbono->precio;

        $precio = match(true) {
            $edad < 12  => round(max($precioBase - 80, 0), 2),
            $edad > 65  => round($precioBase * 0.50, 2),
            default     => $precioBase,
        };

        // ── Asiento único ─────────────────────────────────────────────────
        $codigoAsiento = Abono::generarAsientoUnico();

        if (!$codigoAsiento) {
            return response()->json([
                'error' => 'No se encontró un asiento disponible. Inténtelo de nuevo.',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        // ── Persistencia ──────────────────────────────────────────────────
        $abono = Abono::create([
            'fecha'           => now(),
            'abonado'         => "{$validated['nombre_apellidos']} - {$validated['dni_aficionado']}",
            'edad'            => $edad,
            'telefono'        => $validated['telefono_aficionado'],
            'cuenta_bancaria' => $validated['cuenta_bancaria'],
            'tipo'            => $tipoAbono->id,
            'asiento'         => $codigoAsiento,
            'precio'          => $precio,
        ]);

        // ── Respuesta 201 Created ─────────────────────────────────────────
        return response()->json([
            'mensaje' => 'Abono comprado correctamente.',
            'ticket'  => $this->formatearTicket($abono->load('tipoAbono')),
        ], Response::HTTP_CREATED);
    }

    /*
    |----------------------------------------------------------------------
    | GET /api/abonos/{id}/ticket
    | Devuelve los datos del ticket de un abono existente.
    |----------------------------------------------------------------------
    */
    public function ticket(string $id): JsonResponse
    {
        $abono = Abono::with('tipoAbono')->find($id);

        if (!$abono) {
            return response()->json([
                'error' => 'Abono no encontrado.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'ticket' => $this->formatearTicket($abono),
        ]);
    }

    /*
    |----------------------------------------------------------------------
    | GET /api/abonos  (requiere X-API-Key)
    | Listado completo de abonos.
    |----------------------------------------------------------------------
    */
    public function index(): JsonResponse
    {
        $abonos = Abono::with('tipoAbono')
            ->orderByDesc('asiento')
            ->get()
            ->map(fn ($a) => $this->formatearTicket($a));

        return response()->json([
            'total' => $abonos->count(),
            'datos' => $abonos,
        ]);
    }

    /*
    |----------------------------------------------------------------------
    | Helper privado: normaliza la estructura del ticket para la respuesta.
    |----------------------------------------------------------------------
    */
    private function formatearTicket(Abono $abono): array
    {
        [$nombre, $dni] = explode(' - ', $abono->abonado, 2);

        return [
            'id'             => $abono->id,
            'fecha'          => $abono->fecha,
            'nombre'         => $nombre,
            'dni'            => $dni,
            'telefono'       => $abono->telefono,
            'cuenta_bancaria'=> $abono->cuenta_bancaria,
            'tipo_abono'     => $abono->tipoAbono->descripcion,
            'asiento'        => $abono->asiento,
            'tarifa_especial'=> $abono->getTipoEspecial(),
            'precio'         => number_format($abono->precio, 2, '.', ''),
        ];
    }
}