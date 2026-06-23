<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
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

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            margin-bottom: 20px;
        }

        .filtros {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        label {
            display: block;
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

        .acciones {
            margin-top: 20px;
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
        }
    </style>
</head>
<body>

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="contenedor">
        <h1>Reportes</h1>

        <div class="card">
            <form method="GET" action="<?php echo e(route('reportes.index')); ?>">
                <div class="filtros">
                    <div>
                        <label for="id_estado_actual">Estado</label>
                        <select name="id_estado_actual" id="id_estado_actual">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estado->id_estado_cheque); ?>" <?php echo e(request('id_estado_actual') == $estado->id_estado_cheque ? 'selected' : ''); ?>>
                                    <?php echo e($estado->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label for="beneficiario_nombre">Beneficiario</label>
                        <input type="text" name="beneficiario_nombre" id="beneficiario_nombre" value="<?php echo e(request('beneficiario_nombre')); ?>">
                    </div>

                    <div>
                        <label for="id_banco">Banco</label>
                        <select name="id_banco" id="id_banco">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = $bancos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($banco->id_banco); ?>" <?php echo e(request('id_banco') == $banco->id_banco ? 'selected' : ''); ?>>
                                    <?php echo e($banco->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label for="fecha_vencimiento_desde">Vencimiento Desde</label>
                        <input type="date" name="fecha_vencimiento_desde" id="fecha_vencimiento_desde" value="<?php echo e(request('fecha_vencimiento_desde')); ?>">
                    </div>

                    <div>
                        <label for="fecha_vencimiento_hasta">Vencimiento Hasta</label>
                        <input type="date" name="fecha_vencimiento_hasta" id="fecha_vencimiento_hasta" value="<?php echo e(request('fecha_vencimiento_hasta')); ?>">
                    </div>
                </div>

                <div class="acciones">
                    <button type="submit" class="btn">Filtrar</button>

                    <a href="<?php echo e(route('reportes.pdf', request()->query())); ?>" class="btn">
                        Exportar PDF
                    </a>

                    <a href="<?php echo e(route('reportes.index')); ?>" class="btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>

        <div class="card">
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
                            <td>₲ <?php echo e(number_format($cheque->monto, 0, ',', '.')); ?></td>
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
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\arace\OneDrive\Documentos\7mo semestre\Proyecto de grado\gest-cheq-app\resources\views/reportes/index.blade.php ENDPATH**/ ?>