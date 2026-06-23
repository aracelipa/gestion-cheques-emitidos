<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Cheque</title>
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

        h2 {
            margin: 0 0 15px 0;
            font-size: 22px;
            color: #111827;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 30px;
        }

        .fila {
            padding-bottom: 10px;
            border-bottom: 1px solid #eef2f7;
        }

        .fila-completa {
            grid-column: 1 / -1;
        }

        .label {
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
            color: #111827;
        }

        .valor {
            color: #111827;
        }

        .acciones {
            margin-top: 10px;
        }

        a, button {
            padding: 10px 14px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.2s ease;
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
            margin-top: 10px;
            background: white;
            border-radius: 10px;
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
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }

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
        <h1>Detalle del Cheque</h1>

        <div class="card">
            <div class="grid">
                <div class="fila">
                    <span class="label">Número de Cheque</span>
                    <span class="valor">{{ $cheque->numero_cheque }}</span>
                </div>

                <div class="fila">
                    <span class="label">Estado Actual</span>
                    <span class="valor">{{ $cheque->estadoActual->nombre ?? 'Sin Estado' }}</span>
                </div>

                <div class="fila">
                    <span class="label">Banco</span>
                    <span class="valor">{{ $cheque->cuentaBancaria->banco->nombre ?? 'Sin Banco' }}</span>
                </div>

                <div class="fila">
                    <span class="label">Cuenta Bancaria</span>
                    <span class="valor">{{ $cheque->cuentaBancaria->numero_cuenta ?? 'Sin Cuenta' }}</span>
                </div>

                <div class="fila">
                    <span class="label">Beneficiario</span>
                    <span class="valor">{{ $cheque->beneficiario_nombre }}</span>
                </div>

                <div class="fila">
                    <span class="label">Correo del Beneficiario</span>
                    <span class="valor">{{ $cheque->beneficiario_email ?? 'No Registrado' }}</span>
                </div>

                <div class="fila">
                    <span class="label">Monto</span>
                    <span class="valor">₲ {{ number_format($cheque->monto, 0, ',', '.') }}</span>
                </div>

                <div class="fila">
                    <span class="label">Responsable</span>
                    <span class="valor">{{ $cheque->firma_responsable }}</span>
                </div>

                <div class="fila">
                    <span class="label">Fecha de Emisión</span>
                    <span class="valor">{{ \Carbon\Carbon::parse($cheque->fecha_emision)->format('d/m/Y') }}</span>
                </div>

                <div class="fila">
                    <span class="label">Fecha de Vencimiento</span>
                    <span class="valor">{{ \Carbon\Carbon::parse($cheque->fecha_vencimiento)->format('d/m/Y') }}</span>
                </div>

                <div class="fila fila-completa">
                    <span class="label">Observaciones</span>
                    <span class="valor">{{ $cheque->observaciones ?? 'Sin Observaciones' }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <h2>Historial de Estados</h2>

            <table>
                <thead>
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Usuario</th>
                        <th>Estado Anterior</th>
                        <th>Estado Nuevo</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cheque->historialEstados as $historial)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($historial->fecha_hora_cambio)->setTimezone('-03:00')->format('d/m/Y H:i') }}</td>
                            <td>
                                {{ $historial->usuario->nombre ?? '' }}
                                {{ $historial->usuario->apellido ?? 'Sin Usuario' }}
                            </td>
                            <td>{{ $historial->estadoAnterior->nombre ?? 'Sin Estado Anterior' }}</td>
                            <td>{{ $historial->estadoNuevo->nombre ?? 'Sin Estado Nuevo' }}</td>
                            <td>{{ $historial->motivo_texto ?? ($historial->motivoRechazo->descripcion ?? '-') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="sin-datos">No Hay Historial Registrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="acciones">
            <a href="{{ route('cheques.index') }}" class="btn-secondary">Volver</a>
        </div>
    </div>

</body>
</html>