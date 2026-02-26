<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket de compra - U.D. Almería</title>
    <link rel="stylesheet" href="/Tarea_04/Views/Css/Estilos.css">
</head>

<body>

    <div class="ticket">
        <img class="logo" src="Views/Img/logo-ud-almeria.png" style="height:150px">

        <h2>Compra registrada correctamente</h2>
        <p>----------------------------------------------------------------</p>
        <h2>Ticket de compra</h2>
        <p><b>Fecha:</b> <?= $ticket["fecha"] ?></p>
        <p><b>Abonado:</b> <?= $ticket["abonado"] ?></p>
        <p><b>Teléfono:</b> <?= $ticket["telefono"] ?></p>
        <p><b>Tipo de abono:</b> <?= $ticket["tipo"] ?></p>
        <p><b>Asiento:</b> <?= $ticket["asiento"] ?></p>
        <p class="precio"><b>Precio:</b> <?= number_format($ticket["precio"], 2) ?> €</p>

        <div class="volver">
            <p><a href="index.php">← Volver</a></p>
        </div>
    </div>

</body>

</html>