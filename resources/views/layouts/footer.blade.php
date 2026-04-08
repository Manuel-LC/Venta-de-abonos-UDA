<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('titulo', 'U.D. Almería')</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>

<body>
    <div class="card">
        @yield('contenido')

        <footer class="footer">
            <p>
                <a href="{{ route('login') }}">Acceso administración</a>
            </p>
        </footer>
    </div>
</body>

</html>