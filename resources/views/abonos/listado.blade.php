<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de abonos - U.D. Almería</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>

<body>
    <div class="listado-abonos">
        <h1>Listado de abonos - U.D. Almería</h1>

        <table>
            <tr>
                <th>Tipo de abono</th>
                <th>Asiento</th>
                <th>Datos del abonado</th>
                <th>Tarifa especial</th>
                <th>Precio (€)</th>
            </tr>
            @foreach($abonos as $abono)
            @php
            [$nombre, $dni] = explode(' - ', $abono->abonado);
            @endphp
            <tr>
                <td>
                    <img src="{{ asset('img/' . $abono->getIconoTipo()) }}"
                        width="24"
                        title="{{ $abono->tipoAbono->descripcion }}">
                </td>
                <td>{{ $abono->asiento }}</td>
                <td>
                    {{ $nombre }} ({{ $dni }})
                    &nbsp;
                    <img src="{{ asset('img/telefono.png') }}"
                        title="Tel: {{ $abono->telefono }}"
                        alt="Teléfono" width="20" style="vertical-align:middle">
                    <img src="{{ asset('img/banco.png') }}"
                        title="IBAN: {{ $abono->cuenta_bancaria }}"
                        alt="Cuenta bancaria" width="20" style="vertical-align:middle">
                </td>
                <td>{{ $abono->getTipoEspecial() }}</td>
                <td>{{ number_format($abono->precio, 2) }}</td>
            </tr>
            @endforeach
        </table>

        <div class="volver">
            <a href="{{ route('compra') }}">← Volver a la página principal</a>
        </div>

        <form method="POST" action="{{ route('logout') }}" style="text-align:center; margin-top:10px">
            @csrf
            <button type="submit" style="width:auto; padding: 8px 20px;">Cerrar sesión</button>
        </form>
    </div>
</body>

</html>