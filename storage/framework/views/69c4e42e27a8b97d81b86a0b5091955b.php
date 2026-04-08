<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Acceso listado - U.D. Almería</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/estilos.css')); ?>">
</head>

<body>
    <div class="card">
        <h1>Login de acceso</h1>

        <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <form method="POST" action="<?php echo e(route('login.procesar')); ?>">
            <?php echo csrf_field(); ?>

            <label>Usuario</label>
            <input type="text" name="username" value="<?php echo e(old('username')); ?>">

            <label>Contraseña</label>
            <input type="password" name="password">

            <button type="submit">Entrar</button>
        </form>

        <div class="volver">
            <a href="<?php echo e(route('compra')); ?>">← Volver a la página principal</a>
        </div>
    </div>
</body>

</html><?php /**PATH C:\xampp\htdocs\venta-abonos-uda\resources\views/usuarios/login.blade.php ENDPATH**/ ?>