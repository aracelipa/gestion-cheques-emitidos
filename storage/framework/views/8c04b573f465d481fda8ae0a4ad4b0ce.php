<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            min-height: 100vh;
            color: #111827;
            display: flex;
            flex-direction: column;
        }

        .header {
            padding: 22px 32px 0 32px;
        }

        .header .sistema {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
        }

        .contenedor-login {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card-login {
            width: 100%;
            max-width: 460px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .titulo {
            margin: 0 0 6px 0;
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            text-align: center;
        }

        .subtitulo {
            margin: 0 0 22px 0;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 14px;
            margin-bottom: 6px;
            font-weight: bold;
            color: #111827;
        }

        input {
            width: 100%;
            padding: 11px 12px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #70B291;
            box-shadow: 0 0 0 3px rgba(112, 178, 145, 0.15);
        }

        button {
            width: 100%;
            margin-top: 22px;
            padding: 12px;
            background: #70B291;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.2s ease;
        }

        button:hover {
            background: #4F8F73;
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

    <div class="header">
        <div class="sistema">Sistema de Gestión de Cheques Emitidos</div>
    </div>

    <div class="contenedor-login">
        <div class="card-login">
            <h1 class="titulo">Cambiar Contraseña</h1>
            <p class="subtitulo">Debe actualizar su contraseña antes de continuar.</p>

            <?php if($errors->any()): ?>
                <div class="error-box">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('password.cambiar.guardar')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <label for="password_actual">Contraseña Actual</label>
                <input type="password" name="password_actual" id="password_actual" required>

                <label for="password_nueva">Nueva Contraseña</label>
                <input type="password" name="password_nueva" id="password_nueva" required>

                <label for="password_nueva_confirmation">Confirmar Nueva Contraseña</label>
                <input type="password" name="password_nueva_confirmation" id="password_nueva_confirmation" required>

                <button type="submit">Guardar Nueva Contraseña</button>
            </form>
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\arace\OneDrive\Documentos\7mo semestre\Proyecto de grado\gest-cheq-app\resources\views/auth/cambiar_password.blade.php ENDPATH**/ ?>