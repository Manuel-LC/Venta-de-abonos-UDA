<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Acceso listado - U.D. Almería</title>
    <link rel="stylesheet" href="/Tarea_04/Views/Css/Estilos.css">
</head>

<body>

    <div class="card">

        <h1>Login de acceso</h1>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post">

            <label>Usuario</label>
            <input type="text" name="username" value="<?= htmlspecialchars($username ?? '') ?>">

            <label>Contraseña</label>
            <input type="password" name="password">

            <button type="submit">Entrar</button>

        </form>

        <div class="volver">
            <a href="index.php">← Volver a la página principal</a>
        </div>

    </div>

</body>

</html>