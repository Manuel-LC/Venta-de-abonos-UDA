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
        $tipos_abono = TipoAbono::all();

        // Lee cookies si existen
        $datos = [
            'nombre_apellidos' => $request->cookie('nombre_apellidos', ''),
            'dni'              => $request->cookie('dni', ''),
            'fecha_nacimiento' => $request->cookie('fecha_nacimiento', ''),
            'telefono'         => $request->cookie('telefono', ''),
            'cuenta'           => $request->cookie('cuenta', ''),
        ];

        return view('abonos.compra', ['tipos_abono' => $tipos_abono, 'datos' => $datos]);
    }

    // Procesa el formulario de compra
    public function procesarCompra(CompraAbonoRequest $request): RedirectResponse|View
    {
        $validated = $request->validated();

        // Guardar cookies durante 30 días
        $ttl = 60 * 24 * 30;
        cookie()->queue('nombre_apellidos', $validated['nombre_apellidos'], $ttl);
        cookie()->queue('dni',              $validated['dni_aficionado'],    $ttl);
        cookie()->queue('fecha_nacimiento', $validated['fecha_nacimiento'],  $ttl);
        cookie()->queue('telefono',         $validated['telefono_aficionado'], $ttl);
        cookie()->queue('cuenta',           $validated['cuenta_bancaria'],   $ttl);

        // Calcular edad
        $edad = Carbon::createFromFormat('d/m/Y', $validated['fecha_nacimiento'])->age;

        // Obtener precio
        $tipoAbono = TipoAbono::findOrFail($validated['tipo_abono']);

        // Generar asiento único
        $codigoAsiento = Abono::generarAsientoUnico();

        if (!$codigoAsiento) {
            return back()->withErrors(['asiento' => 'No se encontró un asiento disponible. Inténtelo de nuevo.']);
        }

        // Insertar abono
        $abono = Abono::create([
            'fecha'          => now(),
            'abonado'        => "{$validated['nombre_apellidos']} - {$validated['dni_aficionado']}",
            'edad'           => $edad,
            'telefono'       => $validated['telefono_aficionado'],
            'cuenta_bancaria'=> $validated['cuenta_bancaria'],
            'tipo'           => $tipoAbono->id,
            'asiento'        => $codigoAsiento,
            'precio'         => $tipoAbono->precio,
        ]);

        return redirect()->route('ticket', $abono->id);
    }

    // Muestra el ticket de compra
    public function ticket(string $id): View
    {
        $abono = Abono::with('tipoAbono')->findOrFail($id);
        return view('abonos.ticket', compact('abono'));
    }

    // Listado de abonos (con autenticación)
    public function listado(): View
    {
        $abonos = Abono::with('tipoAbono')->orderByDesc('asiento')->get();
        return view('abonos.listado', compact('abonos'));
    }
}