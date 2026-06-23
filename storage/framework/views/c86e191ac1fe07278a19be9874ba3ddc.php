<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cheque</title>
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

        .fila-estado {
            display: flex;
            gap: 10px;
            align-items: end;
        }

        .fila-estado .campo {
            flex: 1;
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

        @media (max-width: 768px) {
            h1 {
                font-size: 32px;
            }

            .fila-estado {
                flex-direction: column;
                align-items: stretch;
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

        <h1>Editar Cheque</h1>

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
            <form action="<?php echo e(route('cheques.update', $cheque->id_cheque)); ?>" method="POST" class="form-principal">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <label for="id_cuenta_bancaria">Cuenta Bancaria</label>
                <select name="id_cuenta_bancaria" id="id_cuenta_bancaria" required>
                    <option value="">Seleccione una cuenta</option>
                    <?php $__currentLoopData = $cuentas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuenta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cuenta->id_cuenta_bancaria); ?>"
                            <?php echo e(old('id_cuenta_bancaria', $cheque->id_cuenta_bancaria) == $cuenta->id_cuenta_bancaria ? 'selected' : ''); ?>>
                            <?php echo e($cuenta->banco->nombre ?? 'Sin Banco'); ?> - <?php echo e($cuenta->numero_cuenta); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <label for="id_estado_actual">Estado Normal</label>
                <div class="fila-estado">
                    <div class="campo">
                        <select name="id_estado_actual" id="id_estado_actual" required>
                            <option value="">Seleccione un estado</option>
                            <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estado->id_estado_cheque); ?>"
                                    <?php echo e(old('id_estado_actual', $cheque->id_estado_actual) == $estado->id_estado_cheque ? 'selected' : ''); ?>>
                                    <?php echo e($estado->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <?php if(session('usuario_rol') === 'Supervisor'): ?>
                        <div>
                            <a href="<?php echo e(route('cheques.estado_critico', $cheque->id_cheque)); ?>" class="btn-edit">
                                Estado Crítico
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <label for="numero_cheque">Número de Cheque</label>
                <input type="text" name="numero_cheque" id="numero_cheque"
                       value="<?php echo e(old('numero_cheque', $cheque->numero_cheque)); ?>" required>

                <label for="beneficiario_nombre">Beneficiario</label>
                <input type="text" name="beneficiario_nombre" id="beneficiario_nombre"
                       value="<?php echo e(old('beneficiario_nombre', $cheque->beneficiario_nombre)); ?>" required>

                <label for="beneficiario_email">Correo del Beneficiario</label>
                <input type="email" name="beneficiario_email" id="beneficiario_email"
                       value="<?php echo e(old('beneficiario_email', $cheque->beneficiario_email)); ?>">

                <label for="monto">Monto (Gs.)</label>
                <input type="number" step="1" min="1" name="monto" id="monto"
                    value="<?php echo e(old('monto', (int) $cheque->monto)); ?>" required>

                <label for="fecha_emision">Fecha de Emisión</label>
                <input type="date" name="fecha_emision" id="fecha_emision"
                       value="<?php echo e(old('fecha_emision', \Carbon\Carbon::parse($cheque->fecha_emision)->format('Y-m-d'))); ?>" required>

                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento"
                       value="<?php echo e(old('fecha_vencimiento', \Carbon\Carbon::parse($cheque->fecha_vencimiento)->format('Y-m-d'))); ?>" required>

                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="4"><?php echo e(old('observaciones', $cheque->observaciones)); ?></textarea>

                <div class="acciones">
                    <button type="submit" class="btn">Actualizar</button>
                    <a href="<?php echo e(route('cheques.index')); ?>" class="btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\arace\OneDrive\Documentos\7mo semestre\Proyecto de grado\gest-cheq-app\resources\views/cheques/edit.blade.php ENDPATH**/ ?>