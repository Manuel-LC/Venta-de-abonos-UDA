@extends('layouts.footer')

@section('titulo', 'Venta de abonos - U.D. Almería')

@section('contenido')
<div class="layout">
    <img src="{{ asset('img/logo-ud-almeria.png') }}" class="logo" style="height:150px">
    <h1>Venta de abonos - Unión Deportiva Almería</h1>

    <form method="POST" action="{{ route('compra.procesar') }}">
        @csrf

        <label>Nombre y apellidos</label>
        <input type="text" name="nombre_apellidos"
            value="{{ old('nombre_apellidos', $datos['nombre_apellidos']) }}">
        @error('nombre_apellidos')
        <p class="error">{{ $message }}</p>
        @enderror

        <label>DNI</label>
        <input type="text" name="dni_aficionado"
            value="{{ old('dni_aficionado', $datos['dni']) }}">
        @error('dni_aficionado')
        <p class="error">{{ $message }}</p>
        @enderror

        <label>Fecha de nacimiento</label>
        <input type="text" name="fecha_nacimiento"
            value="{{ old('fecha_nacimiento', $datos['fecha_nacimiento']) }}">
        @error('fecha_nacimiento')
        <p class="error">{{ $message }}</p>
        @enderror

        <label>Teléfono</label>
        <input type="tel" name="telefono_aficionado"
            value="{{ old('telefono_aficionado', $datos['telefono']) }}">
        @error('telefono_aficionado')
        <p class="error">{{ $message }}</p>
        @enderror

        <label>Cuenta bancaria</label>
        <input type="text" name="cuenta_bancaria"
            value="{{ old('cuenta_bancaria', $datos['cuenta']) }}">
        @error('cuenta_bancaria')
        <p class="error">{{ $message }}</p>
        @enderror

        <label>Tipo de abono</label>
        <select name="tipo_abono">
            <option value="">-</option>
            @foreach($tipos_abono as $tipo)
            <option value="{{ $tipo->id }}"
                {{ old('tipo_abono') == $tipo->id ? 'selected' : '' }}>
                {{ $tipo->descripcion }} ({{ $tipo->precio }} €)
            </option>
            @endforeach
        </select>
        @error('tipo_abono')
        <p class="error">{{ $message }}</p>
        @enderror

        <div class="control-row">
            <label>
                <input type="checkbox" name="acepto_terminos" value="1"
                {{ old('acepto_terminos') ? 'checked' : '' }}>
                Acepto términos
            </label>
        </div>
        @error('acepto_terminos')
        <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit">Comprar</button>
    </form>
</div>
@endsection