<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('titulo', 'U.D. Almería'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/estilos.css')); ?>">
</head>

<body>
    <div class="card">
        <?php echo $__env->yieldContent('contenido'); ?>

        <footer class="footer">
            <p>
                <a href="<?php echo e(route('login')); ?>">Acceso administración</a>
            </p>
        </footer>
    </div>
</body>

</html><?php /**PATH C:\xampp\htdocs\venta-abonos-uda\resources\views/layouts/footer.blade.php ENDPATH**/ ?>