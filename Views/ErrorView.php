<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link rel="stylesheet" href="Views/Css/Estilos.css">
</head>

<body>

    <?php if ($usuarioLogueado == false): ?>

        <div class="card">
            <h2 style='color:red;'>Acceso denegado</h2>
            <p>No tiene permiso para acceder a esta información.</p>
            <p><a href='index.php?controller=usuarios&action=login'>Ir a la página de acceso</a></p>
        </div>

    <?php else: ?>
        <div class="card">
            <h1>Ha ocurrido un error</h1>

            <p>
                <?= htmlspecialchars($mensajeError ?? "Error desconocido") ?>
            </p>

            <a href="index.php">Volver al inicio</a>
        </div>
    <?php endif; ?>

</body>

</html>