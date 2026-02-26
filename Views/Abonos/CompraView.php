<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Venta de abonos - U.D. Almería</title>
    <link rel="stylesheet" href="/Tarea_04/Views/Css/Estilos.css">
</head>

<body>

    <div class="card">
        <div class='layout'>
            <img src="/Tarea_04/Views/Img/logo-ud-almeria.png" class="logo" style="height:150px">

            <h1>Venta de abonos - Unión Deportiva Almería</h1>

            <form method="post">

                <label>Nombre y apellidos</label>
                <input type="text" name="nombre_apellidos" value="<?= $nombre_apellidos ?? '' ?>">

                <?php if (!empty($errores["nombre_apellidos"])): ?>
                    <p class="error"><?= $errores["nombre_apellidos"] ?></p>
                <?php endif; ?>

                <label>DNI</label>
                <input type="text" name="dni_aficionado" value="<?= $dni ?? '' ?>">

                <?php if (!empty($errores["dni_aficionado"])): ?>
                    <p class="error"><?= $errores["dni_aficionado"] ?></p>
                <?php endif; ?>

                <label>Fecha nacimiento</label>
                <input type="text" name="fecha_nacimiento" value="<?= $fecha_nacimiento ?? '' ?>">

                <?php if (!empty($errores["fecha_nacimiento"])): ?>
                    <p class="error"><?= $errores["fecha_nacimiento"] ?></p>
                <?php endif; ?>

                <label>Teléfono</label>
                <input type="text" name="telefono_aficionado" value="<?= $telefono ?? '' ?>">

                <?php if (!empty($errores["telefono_aficionado"])): ?>
                    <p class="error"><?= $errores["telefono_aficionado"] ?></p>
                <?php endif; ?>

                <label>Cuenta bancaria</label>
                <input type="text" name="cuenta_bancaria" value="<?= $cuenta ?? '' ?>">

                <?php if (!empty($errores["cuenta_bancaria"])): ?>
                    <p class="error"><?= $errores["cuenta_bancaria"] ?></p>
                <?php endif; ?>

                <label>Tipo de abono</label>
                <select name="tipo_abono">
                    <option value="">-</option>
                    <?php foreach ($tipos_abono as $tipo): ?>
                        <option value="<?= $tipo["id"] ?>">
                            <?= $tipo["descripcion"] ?> (<?= $tipo["precio"] ?> €)
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if (!empty($errores["tipo_abono"])): ?>
                    <p class="error"><?= $errores["tipo_abono"] ?></p>
                <?php endif; ?>

                <label>
                    <input type="checkbox" name="acepto_terminos" <?= !empty($acepto_terminos) ? 'checked' : '' ?>>
                    Acepto términos
                </label>

                <?php if (!empty($errores["acepto_terminos"])): ?>
                    <p class="error"><?= $errores["acepto_terminos"] ?></p>
                <?php endif; ?>

                <button type="submit">Comprar</button>

            </form>
        </div>

        <?php require_once __DIR__ . '/../Layout/Footer.php'; ?>
    </div>

</body>

</html>