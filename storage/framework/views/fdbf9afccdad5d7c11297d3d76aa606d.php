<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado Crítico</title>
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
            margin-bottom: 20px;
        }

        .form-principal {
            width: 100%;
            margin: 0;
        }

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

        input, select, textarea {
            width: 100%;
            padding: 10px 12px;
            margin-top: 4px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
        }

        input:focus, select:focus, textarea:focus {
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

        .btn-edit {
            background: #C9A227;
            color: white;
        }

        .btn-edit:hover {
            background: #A8841E;
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

        .info-box {
            background: #f9fafb;
            color: #111827;
            padding: 18px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            line-height: 1.7;
        }

        .warning-box {
            background: #fff8e6;
            color: #8a6d1f;
            padding: 14px 16px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: 1px solid #f0dfab;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 32px;
            }

            .acciones {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="contenedor">
        <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <h1>Estado Crítico</h1>

        <div class="card">
            <div class="info-box">
                <strong>Cheque:</strong> <?php echo e($cheque->numero_cheque); ?> <br>
                <strong>Estado Actual:</strong> <?php echo e($cheque->estadoActual->nombre ?? 'Sin Estado'); ?> <br>
                <strong>Beneficiario:</strong> <?php echo e($cheque->beneficiario_nombre); ?>

            </div>

            <div class="warning-box">
                Para los estados <strong>Rechazado</strong> y <strong>Anulado</strong>, debe indicar un motivo.
            </div>

            <?php if($errors->any()): ?>
                <div class="error-box">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('cheques.estado_critico.guardar', $cheque->id_cheque)); ?>" method="POST" class="form-principal">
                <?php echo csrf_field(); ?>

                <label for="id_estado_nuevo">Nuevo Estado Crítico</label>
                <select name="id_estado_nuevo" id="id_estado_nuevo" required>
                    <option value="">Seleccione un estado</option>
                    <?php $__currentLoopData = $estadosCriticos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($estado->id_estado_cheque); ?>" <?php echo e(old('id_estado_nuevo') == $estado->id_estado_cheque ? 'selected' : ''); ?>>
                            <?php echo e($estado->nombre); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <label for="id_motivo_rechazo">Motivo Catalogado</label>
                <select name="id_motivo_rechazo" id="id_motivo_rechazo">
                    <option value="">Seleccione un motivo (opcional)</option>
                    <?php $__currentLoopData = $motivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($motivo->id_motivo_rechazo); ?>" <?php echo e(old('id_motivo_rechazo') == $motivo->id_motivo_rechazo ? 'selected' : ''); ?>>
                            <?php echo e($motivo->descripcion); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <label for="motivo_texto">Detalle del Motivo</label>
                <textarea name="motivo_texto" id="motivo_texto" rows="4"><?php echo e(old('motivo_texto')); ?></textarea>

                <div class="acciones">
                    <button type="submit" class="btn-edit">Guardar Cambio Crítico</button>
                    <a href="<?php echo e(route('cheques.edit', $cheque->id_cheque)); ?>" class="btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\arace\OneDrive\Documentos\7mo semestre\Proyecto de grado\gest-cheq-app\resources\views/cheques/estado_critico.blade.php ENDPATH**/ ?>