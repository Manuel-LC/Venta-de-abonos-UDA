

<?php $__env->startSection('titulo', 'Venta de abonos - U.D. Almería'); ?>

<?php $__env->startSection('contenido'); ?>
<div class="layout">
    <img src="<?php echo e(asset('img/logo-ud-almeria.png')); ?>" class="logo" style="height:150px">
    <h1>Venta de abonos - Unión Deportiva Almería</h1>

    <form method="POST" action="<?php echo e(route('compra.procesar')); ?>">
        <?php echo csrf_field(); ?>

        <label>Nombre y apellidos</label>
        <input type="text" name="nombre_apellidos"
            value="<?php echo e(old('nombre_apellidos', $datos['nombre_apellidos'])); ?>">
        <?php $__errorArgs = ['nombre_apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>DNI</label>
        <input type="text" name="dni_aficionado"
            value="<?php echo e(old('dni_aficionado', $datos['dni'])); ?>">
        <?php $__errorArgs = ['dni_aficionado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Fecha de nacimiento</label>
        <input type="text" name="fecha_nacimiento"
            value="<?php echo e(old('fecha_nacimiento', $datos['fecha_nacimiento'])); ?>">
        <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Teléfono</label>
        <input type="tel" name="telefono_aficionado"
            value="<?php echo e(old('telefono_aficionado', $datos['telefono'])); ?>">
        <?php $__errorArgs = ['telefono_aficionado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Cuenta bancaria</label>
        <input type="text" name="cuenta_bancaria"
            value="<?php echo e(old('cuenta_bancaria', $datos['cuenta'])); ?>">
        <?php $__errorArgs = ['cuenta_bancaria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Tipo de abono</label>
        <select name="tipo_abono">
            <option value="">-</option>
            <?php $__currentLoopData = $tipos_abono; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($tipo->id); ?>"
                <?php echo e(old('tipo_abono') == $tipo->id ? 'selected' : ''); ?>>
                <?php echo e($tipo->descripcion); ?> (<?php echo e($tipo->precio); ?> €)
            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['tipo_abono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <div class="control-row">
            <label>
                <input type="checkbox" name="acepto_terminos" value="1"
                <?php echo e(old('acepto_terminos') ? 'checked' : ''); ?>>
                Acepto términos
            </label>
        </div>
        <?php $__errorArgs = ['acepto_terminos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <button type="submit">Comprar</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\venta-abonos-uda\resources\views/abonos/compra.blade.php ENDPATH**/ ?>