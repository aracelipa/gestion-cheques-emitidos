<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
            color: #111827;
        }

        .contenedor {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            background: white;
            padding: 16px 20px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .topbar-info {
            font-size: 15px;
            color: #111827;
        }

        h1 {
            margin: 0 0 20px 0;
            font-size: 42px;
            color: #111827;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .form-principal,
        .logout-form {
            margin: 0;
        }

        label {
            display: block;
            margin-top: 14px;
            margin-bottom: 6px;
            font-weight: bold;
            color: #111827;
        }

        input, select {
            width: 100%;
            padding: 10px 12px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #70B291;
            box-shadow: 0 0 0 3px rgba(112, 178, 145, 0.15);
        }

        .acciones {
            margin-top: 24px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        a, button {
            padding: 10px 14px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.2s ease;
            display: inline-block;
        }

        .btn {
            background: #70B291;
            color: white;
        }

        .btn:hover {
            background: #4F8F73;
        }

        .btn-danger {
            background: #B85C5C;
            color: white;
        }

        .btn-danger:hover {
            background: #994848;
        }

        .btn-secondary {
            background: #7B8F87;
            color: white;
        }

        .btn-secondary:hover {
            background: #66786F;
        }

        .error-box {
            background: #fef2f2;
            color: #991b1b;
            padding: 14px 16px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: 1px solid #f5c2c7;
        }

        .error-box ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>

    <div class="contenedor">
        <div class="topbar">
            <div class="topbar-info">
                <strong>Usuario:</strong> <?php echo e(session('usuario_nombre')); ?> |
                <strong>Rol:</strong> <?php echo e(session('usuario_rol')); ?>

            </div>

            <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-danger">Cerrar Sesión</button>
            </form>
        </div>

        <h1>Registrar Usuario</h1>

        <?php if($errors->any()): ?>
            <div class="error-box">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card">
            <form action="<?php echo e(route('usuarios.store')); ?>" method="POST" class="form-principal">
                <?php echo csrf_field(); ?>

                <label for="id_rol">Rol</label>
                <select name="id_rol" id="id_rol" required>
                    <option value="">Seleccione un rol</option>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($rol->id_rol); ?>" <?php echo e(old('id_rol') == $rol->id_rol ? 'selected' : ''); ?>>
                            <?php echo e($rol->nombre); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <label for="nickname">Nickname</label>
                <input type="text" name="nickname" id="nickname" value="<?php echo e(old('nickname')); ?>" required>

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo e(old('nombre')); ?>" required>

                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" value="<?php echo e(old('apellido')); ?>" required>

                <label for="email">Correo</label>
                <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>">

                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>

                <label for="estado">Estado</label>
                <select name="estado" id="estado" required>
                    <option value="">Seleccione un estado</option>
                    <option value="Activo" <?php echo e(old('estado') == 'Activo' ? 'selected' : ''); ?>>Activo</option>
                    <option value="Bloqueado" <?php echo e(old('estado') == 'Bloqueado' ? 'selected' : ''); ?>>Bloqueado</option>
                    <option value="Inactivo" <?php echo e(old('estado') == 'Inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                </select>

                <div class="acciones">
                    <button type="submit" class="btn">Guardar</button>
                    <a href="<?php echo e(route('usuarios.index')); ?>" class="btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\arace\OneDrive\Documentos\7mo semestre\Proyecto de grado\gest-cheq-app\resources\views/usuarios/create.blade.php ENDPATH**/ ?>