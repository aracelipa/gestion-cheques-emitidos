<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
            color: #111827;
        }

        .contenedor {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h1 {
            margin: 0 0 20px 0;
            font-size: 42px;
            color: #111827;
        }

        .alert {
            padding: 14px 16px;
            margin-bottom: 20px;
            border-radius: 10px;
            background: #e9f7ef;
            color: #1f5133;
            border: 1px solid #cfe8d7;
        }

        .error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #f5c2c7;
        }

        .acciones-superiores {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
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

        .btn-edit {
            background: #C9A227;
            color: white;
        }

        .btn-edit:hover {
            background: #A8841E;
        }

        .btn-secondary {
            background: #7B8F87;
            color: white;
        }

        .btn-secondary:hover {
            background: #66786F;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
            color: #111827;
        }

        th {
            background: #f9fafb;
            color: #111827;
            font-weight: bold;
        }

        tr:hover td {
            background: #fafcff;
        }

        .acciones {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        form {
            display: inline;
            margin: 0;
        }

        .sin-datos {
            color: #6b7280;
            text-align: center;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 32px;
            }

            table {
                font-size: 14px;
            }

            .acciones {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="contenedor">
        <h1>Notificaciones</h1>

        <?php if(session('success')): ?>
            <div class="alert">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert error">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Cheque</th>
                        <th>Asunto</th>
                        <th>Estado</th>
                        <th>Destinatario</th>
                        <th>Fecha Programada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $notificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($notificacion->tipo_notificacion); ?></td>
                            <td><?php echo e($notificacion->cheque->numero_cheque ?? '-'); ?></td>
                            <td><?php echo e($notificacion->asunto); ?></td>
                            <td><?php echo e($notificacion->estado); ?></td>
                            <td><?php echo e($notificacion->destinatario_email ?? ($notificacion->usuarioDestino->nickname ?? '-')); ?></td>
                            <td>
                                <?php echo e($notificacion->fecha_programada ? $notificacion->fecha_programada->format('d/m/Y H:i') : '-'); ?>

                            </td>
                            <td class="acciones">
                                <?php if($notificacion->tipo_notificacion === 'SUPERVISOR_REVISION' && $notificacion->estado === 'Pendiente'): ?>
                                    <form action="<?php echo e(route('notificaciones.verificar', $notificacion->id_notificacion)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn-edit">Verificar</button>
                                    </form>
                                <?php endif; ?>

                                <?php if($notificacion->tipo_notificacion === 'BENEFICIARIO_PREVIA' && $notificacion->estado === 'Pendiente'): ?>
                                    <form action="<?php echo e(route('notificaciones.enviada', $notificacion->id_notificacion)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn">Marcar Enviada</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="sin-datos">No Hay Notificaciones Registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\arace\OneDrive\Documentos\7mo semestre\Proyecto de grado\gest-cheq-app\resources\views/notificaciones/index.blade.php ENDPATH**/ ?>