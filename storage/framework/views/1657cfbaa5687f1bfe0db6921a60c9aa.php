<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de abonos - U.D. Almería</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/estilos.css')); ?>">
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
            <?php $__currentLoopData = $abonos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abono): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            [$nombre, $dni] = explode(' - ', $abono->abonado);
            ?>
            <tr>
                <td>
                    <img src="<?php echo e(asset('img/' . $abono->getIconoTipo())); ?>"
                        width="24"
                        title="<?php echo e($abono->tipoAbono->descripcion); ?>">
                </td>
                <td><?php echo e($abono->asiento); ?></td>
                <td>
                    <?php echo e($nombre); ?> (<?php echo e($dni); ?>)
                    &nbsp;
                    <img src="<?php echo e(asset('img/telefono.png')); ?>"
                        title="Tel: <?php echo e($abono->telefono); ?>"
                        alt="Teléfono" width="20" style="vertical-align:middle">
                    <img src="<?php echo e(asset('img/banco.png')); ?>"
                        title="IBAN: <?php echo e($abono->cuenta_bancaria); ?>"
                        alt="Cuenta bancaria" width="20" style="vertical-align:middle">
                </td>
                <td><?php echo e($abono->getTipoEspecial()); ?></td>
                <td><?php echo e(number_format($abono->precio, 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

        <div class="volver">
            <a href="<?php echo e(route('compra')); ?>">← Volver a la página principal</a>
        </div>

        <form method="POST" action="<?php echo e(route('logout')); ?>" style="text-align:center; margin-top:10px">
            <?php echo csrf_field(); ?>
            <button type="submit" style="width:auto; padding: 8px 20px;">Cerrar sesión</button>
        </form>
    </div>
</body>

</html><?php /**PATH C:\xampp\htdocs\venta-abonos-uda\resources\views/abonos/listado.blade.php ENDPATH**/ ?>