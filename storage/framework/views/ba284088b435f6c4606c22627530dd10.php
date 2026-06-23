<nav class="navbar-sistema">
    <style>
        .navbar-sistema {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .navbar-sistema .navbar-contenedor {
            max-width: 1200px;
            margin: 0 auto;
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .navbar-sistema .navbar-izquierda {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .navbar-sistema .navbar-brand {
            font-size: 20px;
            font-weight: bold;
            color: #111827;
            text-decoration: none;
        }

        .navbar-sistema .navbar-brand.activo {
            color: #2f6b4f;
            opacity: 0.95;
        }

        .navbar-sistema .navbar-links {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .navbar-sistema .navbar-link {
            text-decoration: none;
            color: #374151;
            padding: 8px 12px;
            border-radius: 8px;
            transition: 0.2s ease;
            font-size: 14px;
        }

        .navbar-sistema .navbar-link:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .navbar-sistema .navbar-link.activo {
            background: #e8f3ed;
            color: #2f6b4f;
            font-weight: bold;
        }

        .navbar-sistema .navbar-derecha {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .navbar-sistema .navbar-usuario {
            font-size: 14px;
            color: #111827;
        }

        .navbar-sistema .btn-danger {
            background: #B85C5C;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 14px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.2s ease;
        }

        .navbar-sistema .btn-danger:hover {
            background: #994848;
        }

        .navbar-sistema .logout-form {
            margin: 0;
        }

        @media (max-width: 768px) {
            .navbar-sistema .navbar-contenedor {
                align-items: flex-start;
            }

            .navbar-sistema .navbar-izquierda,
            .navbar-sistema .navbar-derecha {
                width: 100%;
            }
        }
    </style>

    <div class="navbar-contenedor">
        <div class="navbar-izquierda">
            <a href="<?php echo e(route('panel.index')); ?>"
               class="navbar-brand <?php echo e(request()->routeIs('panel.index') ? 'activo' : ''); ?>">
                Gestión de Cheques
            </a>

            <div class="navbar-links">
                <?php if(in_array(session('usuario_rol'), ['Operador', 'Supervisor'])): ?>
                    <a href="<?php echo e(route('cheques.index')); ?>"
                       class="navbar-link <?php echo e(request()->routeIs('cheques.*') ? 'activo' : ''); ?>">
                        Cheques
                    </a>
                <?php endif; ?>

                <?php if(session('usuario_rol') === 'Supervisor'): ?>
                    <a href="<?php echo e(route('bitacoras.index')); ?>"
                       class="navbar-link <?php echo e(request()->routeIs('bitacoras.*') ? 'activo' : ''); ?>">
                        Bitácora
                    </a>

                    <a href="<?php echo e(route('notificaciones.index')); ?>"
                       class="navbar-link <?php echo e(request()->routeIs('notificaciones.*') ? 'activo' : ''); ?>">
                        Notificaciones
                    </a>

                    <a href="<?php echo e(route('reportes.index')); ?>"
                       class="navbar-link <?php echo e(request()->routeIs('reportes.*') ? 'activo' : ''); ?>">
                        Reportes
                    </a>
                <?php endif; ?>

                <?php if(session('usuario_rol') === 'Administrador'): ?>
                    <a href="<?php echo e(route('usuarios.index')); ?>"
                       class="navbar-link <?php echo e(request()->routeIs('usuarios.*') ? 'activo' : ''); ?>">
                        Usuarios
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="navbar-derecha">
            <div class="navbar-usuario">
                <strong>Usuario:</strong> <?php echo e(session('usuario_nombre')); ?> |
                <strong>Rol:</strong> <?php echo e(session('usuario_rol')); ?>

            </div>

            <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-danger">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</nav><?php /**PATH C:\Users\arace\OneDrive\Documentos\7mo semestre\Proyecto de grado\gest-cheq-app\resources\views/partials/navbar.blade.php ENDPATH**/ ?>