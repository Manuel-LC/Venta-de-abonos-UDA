<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket de compra - U.D. Almería</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/estilos.css')); ?>">
</head>

<body>
    <div class="ticket">
        <img class="logo" src="<?php echo e(asset('img/logo-ud-almeria.png')); ?>" style="height:150px">

        <h2>Compra registrada correctamente</h2>
        <p>----------------------------------------------------------------</p>
        <h2>Ticket de compra</h2>

        <p><b>Fecha:</b> <?php echo e($abono->fecha); ?></p>
        <p><b>Abonado:</b> <?php echo e($abono->abonado); ?></p>
        <p><b>Teléfono:</b> <?php echo e($abono->telefono); ?></p>
        <p><b>Tipo de abono:</b> <?php echo e($abono->tipoAbono->descripcion); ?></p>
        <p><b>Asiento:</b> <span class="asiento"><?php echo e($abono->asiento); ?></span></p>
        <p class="precio"><b>Precio:</b> <?php echo e(number_format($abono->precio, 2)); ?> €</p>

        <div class="volver">
            <a href="<?php echo e(route('compra')); ?>">← Volver</a>
        </div>
    </div>
</body>

</html><?php /**PATH C:\xampp\htdocs\venta-abonos-uda\resources\views/abonos/ticket.blade.php ENDPATH**/ ?>