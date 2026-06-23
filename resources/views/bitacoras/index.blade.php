<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bitácora del Sistema</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            vertical-align: top;
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

    @include('partials.navbar')

    <div class="contenedor">
        <h1>Bitácora del Sistema</h1>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Usuario</th>
                        <th>Módulo</th>
                        <th>Acción</th>
                        <th>Cheque</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bitacoras as $bitacora)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($bitacora->fecha_hora_evento)->setTimezone('-03:00')->format('d/m/Y H:i') }}</td>
                            <td>
                                {{ $bitacora->usuario->nombre ?? '' }}
                                {{ $bitacora->usuario->apellido ?? 'Sin Usuario' }}
                            </td>
                            <td>{{ $bitacora->modulo }}</td>
                            <td>{{ $bitacora->accion }}</td>
                            <td>{{ $bitacora->cheque->numero_cheque ?? '-' }}</td>
                            <td>{{ $bitacora->descripcion }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="sin-datos">No Hay Registros en Bitácora.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>