<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompraAbonoRequest;
use App\Models\Abono;
use App\Models\TipoAbono;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbonosController extends Controller
{
    // Muestra el formulario de compra
    public function compra(Request $request): View
    {
        // Lee cookies si existen
        $datos = [
            'nombre_apellidos' => $request->cookie('nombre_apellidos', ''),
            'dni'              => $request->cookie('dni', ''),
            'fecha_nacimiento' => $request->cookie('fecha_nacimiento', ''),
            'telefono'         => $request->cookie('telefono', ''),
            'cuenta'           => $request->cookie('cuenta', ''),
        ];

        /*
        |----------------------------------------------------------------------
        | CAMBIO (componente): ya no se pasa $tipos_abono a la vista porque
        | ahora el componente <x-select-tipo-abono> los carga por sí mismo.
        |----------------------------------------------------------------------
        */
        return view('abonos.compra', compact('datos'));
    }

    // Procesa el formulario de compra
    public function procesarCompra(CompraAbonoRequest $request): RedirectResponse|View
    {
        $validated = $request->validated();

        // Guardar cookies durante 30 días
        $ttl = 60 * 24 * 30;
        cookie()->queue('nombre_apellidos', $validated['nombre_apellidos'],     $ttl);
        cookie()->queue('dni',              $validated['dni_aficionado'],        $ttl);
        cookie()->queue('fecha_nacimiento', $validated['fecha_nacimiento'],      $ttl);
        cookie()->queue('telefono',         $validated['telefono_aficionado'],   $ttl);
        cookie()->queue('cuenta',           $validated['cuenta_bancaria'],       $ttl);

        /*
        |----------------------------------------------------------------------
        | CAMBIO (fecha): se usa createFromFormat('d/m/Y', ...) porque el
        | campo llega en formato español; antes la validación usaba 'date'
        | (que espera Y-m-d) y podía devolver una edad incorrecta o errónea.
        |----------------------------------------------------------------------
        */
        $edad = Carbon::createFromFormat('d/m/Y', $validated['fecha_nacimiento'])->age;

        // Obtener precio base según tipo de abono
        $tipoAbono  = TipoAbono::findOrFail($validated['tipo_abono']);
        $precioBase = $tipoAbono->precio;

        /*
        |----------------------------------------------------------------------
        | CAMBIO (precio): antes se aplicaba siempre el precio base sin tener
        | en cuenta la tarifa especial. Las reglas correctas son:
        |   - Niños/as (< 12 años):          rebaja fija de 80 €
        |   - Jubilados/as (> 65 años):       rebaja del 50 % sobre el precio base
        |   - Resto de abonados:              precio base sin descuento
        |
        | Se usa max(..., 0) para evitar precios negativos si el precio base
        | fuera inferior a 80 €.
        |----------------------------------------------------------------------
        */
        $precio = match(true) {
            $edad < 12  => round(max($precioBase - 80, 0), 2),
            $edad > 65  => round($precioBase * 0.50, 2),
            default     => $precioBase,
        };

        // Generar asiento único
        $codigoAsiento = Abono::generarAsientoUnico();

        if (!$codigoAsiento) {
            return back()->withErrors(['asiento' => 'No se encontró un asiento disponible. Inténtelo de nuevo.']);
        }

        // Insertar abono
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

        return redirect()->route('ticket', $abono->id);
    }

    // Muestra el ticket de compra
    public function ticket(string $id): View
    {
        $abono = Abono::with('tipoAbono')->findOrFail($id);
        return view('abonos.ticket', compact('abono'));
    }

    // Listado de abonos (protegido con auth nativo)
    public function listado(): View
    {
        $abonos = Abono::with('tipoAbono')->orderByDesc('asiento')->get();
        return view('abonos.listado', compact('abonos'));
    }
}