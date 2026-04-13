{{--
    Carga los tipos de abono directamente desde el modelo (sin necesitar
    que el controlador los pase explícitamente cada vez que se use).
--}}
@php
    $tipos = \App\Models\TipoAbono::all();
@endphp

<select name="tipo_abono" {{ $attributes }}>
    <option value="">— Selecciona un tipo —</option>
    @foreach($tipos as $tipo)
        <option
            value="{{ $tipo->id }}"
            {{ old('tipo_abono') == $tipo->id ? 'selected' : '' }} >
            {{ $tipo->descripcion }} ({{ number_format($tipo->precio, 2) }} €)
        </option>
    @endforeach
</select>