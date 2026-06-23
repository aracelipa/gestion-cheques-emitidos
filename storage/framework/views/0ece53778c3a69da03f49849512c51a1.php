<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cheques</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .fecha {
            text-align: right;
            margin-bottom: 15px;
            font-size: 11px;
        }

        .monto {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #f3f4f6;
            font-weight: bold;
        }

        .sin-datos {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Reporte de Cheques</h1>

    <div class="fecha">
        Generado el <?php echo e(now()->setTimezone('-03:00')->format('d/m/Y H:i')); ?>

    </div>

    <table>
        <thead>
            <tr>
                <th>N° Cheque</th>
                <th>Banco</th>
                <th>Cuenta</th>
                <th>Beneficiario</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Vencimiento</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cheques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($cheque->numero_cheque); ?></td>
                    <td><?php echo e($cheque->cuentaBancaria->banco->nombre ?? 'Sin Banco'); ?></td>
                    <td><?php echo e($cheque->cuentaBancaria->numero_cuenta ?? 'Sin Cuenta'); ?></td>
                    <td><?php echo e($cheque->beneficiario_nombre); ?></td>
                    <td class="monto">₲ <?php echo e(number_format($cheque->monto, 0, ',', '.')); ?></td>
                    <td><?php echo e($cheque->estadoActual->nombre ?? 'Sin Estado'); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($cheque->fecha_vencimiento)->format('d/m/Y')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="sin-datos">No Hay Resultados Para Los Filtros Aplicados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html><?php /**PATH C:\Users\arace\OneDrive\Documentos\7mo semestre\Proyecto de grado\gest-cheq-app\resources\views/reportes/pdf.blade.php ENDPATH**/ ?>