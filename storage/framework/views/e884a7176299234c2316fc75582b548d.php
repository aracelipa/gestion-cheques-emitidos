<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
            color: #111827;
        }

        .contenedor {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h1 {
            margin: 0 0 20px 0;
            font-size: 42px;
            color: #111827;
        }

        .subtitulo {
            margin-bottom: 25px;
            color: #6b7280;
            font-size: 15px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .card h2 {
            margin: 0 0 10px 0;
            font-size: 22px;
            color: #111827;
        }

        .card p {
            margin: 0 0 18px 0;
            color: #6b7280;
            line-height: 1.5;
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

        @media (max-width: 768px) {
            h1 {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="contenedor">
        <h1>Panel Principal</h1>
        <div class="subtitulo">Seleccione una opción para continuar.</div>

        <div class="grid">
            <?php if(session('usuario_rol') === 'Operador'): ?>
                <div class="card">
                    <h2>Cheques</h2>
                    <p>Registre cheques emitidos, actualice datos y gestione estados normales.</p>
                    <a href="<?php echo e(route('cheques.index')); ?>" class="btn">Ir a Cheques</a>
                </div>
            <?php endif; ?>

            <?php if(session('usuario_rol') === 'Supervisor'): ?>
                <div class="card">
                    <h2>Cheques</h2>
                    <p>Consulte cheques, actualice estados normales y gestione estados críticos.</p>
                    <a href="<?php echo e(route('cheques.index')); ?>" class="btn">Ir a Cheques</a>
                </div>

                <div class="card">
                    <h2>Bitácora</h2>
                    <p>Revise la trazabilidad de eventos registrados en el sistema.</p>
                    <a href="<?php echo e(route('bitacoras.index')); ?>" class="btn">Ver Bitácora</a>
                </div>

                <div class="card">
                    <h2>Notificaciones</h2>
                    <p>Revise y gestione las notificaciones pendientes del sistema.</p>
                    <a href="<?php echo e(route('notificaciones.index')); ?>" class="btn">Ver Notificaciones</a>
                </div>

                <div class="card">
                    <h2>Reportes</h2>
                    <p>Consulte reportes por estado, beneficiario, banco y fecha de vencimiento.</p>
                    <a href="<?php echo e(route('reportes.index')); ?>" class="btn">Ver Reportes</a>
                </div>
            <?php endif; ?>

            <?php if(session('usuario_rol') === 'Administrador'): ?>
                <div class="card">
                    <h2>Usuarios</h2>
                    <p>Administre usuarios, roles y estados de acceso del sistema.</p>
                    <a href="<?php echo e(route('usuarios.index')); ?>" class="btn">Gestión de Usuarios</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\arace\OneDrive\Documentos\7mo semestre\Proyecto de grado\gest-cheq-app\resources\views/panel/index.blade.php ENDPATH**/ ?>