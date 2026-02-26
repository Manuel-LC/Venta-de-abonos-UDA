<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de abonos - U.D. Almería</title>
    <link rel="stylesheet" href="/Tarea_04/Views/Css/Estilos.css">
</head>

<body>
        <div class="listado-abonos">
            <h1>Listado de abonos - U.D. Almería</h1>

            <table>
                <tr>
                    <th>Tipo de abono</th>
                    <th>Asiento</th>
                    <th>Datos del abonado</th>
                    <th>Abonado con tarifa especial</th>
                    <th>Precio (€)</th>
                </tr>

                <?php foreach ($abonos as $abono):
                    // Datos del abonado, vienen en formato "Nombre Apellidos - DNI"
                    $datos = explode(" - ", $abono["abonado"]);
                    $nombreCompleto = $datos[0];
                    $dni = $datos[1] ?? "";
                ?>
                    <tr>
                        <td>
                            <img src="Views/Img/<?= htmlspecialchars($abono['icono']) ?>"
                                width="24"
                                title="<?= htmlspecialchars($abono['tipo_descripcion']) ?>">
                        </td>

                        <td><?= htmlspecialchars($abono["asiento"]) ?></td>
                        <td>
                            <?= htmlspecialchars($nombreCompleto) ?> (<?= $dni ?>)
                            &nbsp;
                            <!-- Teléfono -->
                            <img src="Views/Img/telefono.png"
                                title="Tel: <?= htmlspecialchars($abono["telefono"]) ?>"
                                alt="Teléfono" width="20" style="vertical-align:middle">

                            <!-- Cuenta bancaria -->
                            <img src="Views/Img/banco.png"
                                title="IBAN: <?= htmlspecialchars($abono["cuenta_bancaria"]) ?>"
                                alt="Cuenta bancaria" width="20" style="vertical-align:middle">

                        </td>
                        <td><?= htmlspecialchars($abono['especial']) ?></td>
                        <td><?= number_format($abono["precio"], 2) ?></td>
                    </tr>
                <?php endforeach; ?>

            </table>
            <div class="volver">
                <a href="index.php">← Volver a la página principal</a>
            </div>
        </div>
</body>

</html>