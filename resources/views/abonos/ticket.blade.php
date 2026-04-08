<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket de compra - U.D. Almería</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>

<body>
    <div class="ticket">
        <img class="logo" src="{{ asset('img/logo-ud-almeria.png') }}" style="height:150px">

        <h2>Compra registrada correctamente</h2>
        <p>----------------------------------------------------------------</p>
        <h2>Ticket de compra</h2>

        <p><b>Fecha:</b> {{ $abono->fecha }}</p>
        <p><b>Abonado:</b> {{ $abono->abonado }}</p>
        <p><b>Teléfono:</b> {{ $abono->telefono }}</p>
        <p><b>Tipo de abono:</b> {{ $abono->tipoAbono->descripcion }}</p>
        <p><b>Asiento:</b> <span class="asiento">{{ $abono->asiento }}</span></p>
        <p class="precio"><b>Precio:</b> {{ number_format($abono->precio, 2) }} €</p>

        <div class="volver">
            <a href="{{ route('compra') }}">← Volver</a>
        </div>
    </div>
</body>

</html>