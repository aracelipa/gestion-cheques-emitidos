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
        Generado el {{ now()->setTimezone('-03:00')->format('d/m/Y H:i') }}
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
            @forelse($cheques as $cheque)
                <tr>
                    <td>{{ $cheque->numero_cheque }}</td>
                    <td>{{ $cheque->cuentaBancaria->banco->nombre ?? 'Sin Banco' }}</td>
                    <td>{{ $cheque->cuentaBancaria->numero_cuenta ?? 'Sin Cuenta' }}</td>
                    <td>{{ $cheque->beneficiario_nombre }}</td>
                    <td class="monto">₲ {{ number_format($cheque->monto, 0, ',', '.') }}</td>
                    <td>{{ $cheque->estadoActual->nombre ?? 'Sin Estado' }}</td>
                    <td>{{ \Carbon\Carbon::parse($cheque->fecha_vencimiento)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="sin-datos">No Hay Resultados Para Los Filtros Aplicados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>