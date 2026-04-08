<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Acceso listado - U.D. Almería</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>

<body>
    <div class="card">
        <h1>Login de acceso</h1>

        @error('login')
        <p class="error">{{ $message }}</p>
        @enderror

        <form method="POST" action="{{ route('login.procesar') }}">
            @csrf

            <label>Usuario</label>
            <input type="text" name="username" value="{{ old('username') }}">

            <label>Contraseña</label>
            <input type="password" name="password">

            <button type="submit">Entrar</button>
        </form>

        <div class="volver">
            <a href="{{ route('compra') }}">← Volver a la página principal</a>
        </div>
    </div>
</body>

</html>