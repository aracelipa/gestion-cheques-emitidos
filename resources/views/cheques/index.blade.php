<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Cheques</title>
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

    @include('partials.navbar')

    <div class="contenedor">
        <h1>Lista de Cheques</h1>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="acciones-superiores">
            @if(session('usuario_rol') === 'Operador')
                <a href="{{ route('cheques.create') }}" class="btn">Nuevo Cheque</a>
            @endif

            @if(session('usuario_rol') === 'Supervisor')
                <a href="{{ route('bitacoras.index') }}" class="btn-secondary">Ver Bitácora</a>
            @endif

            @if(session('usuario_rol') === 'Administrador')
                <a href="{{ route('usuarios.index') }}" class="btn-secondary">Gestión de Usuarios</a>
            @endif
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cheques as $cheque)
                        <tr>
                            <td>{{ $cheque->numero_cheque }}</td>
                            <td>{{ $cheque->cuentaBancaria->banco->nombre ?? 'Sin Banco' }}</td>
                            <td>{{ $cheque->cuentaBancaria->numero_cuenta ?? 'Sin Cuenta' }}</td>
                            <td>{{ $cheque->beneficiario_nombre }}</td>
                            <td>₲ {{ number_format($cheque->monto, 0, ',', '.') }}</td>
                            <td>{{ $cheque->estadoActual->nombre ?? 'Sin Estado' }}</td>
                            <td>{{ \Carbon\Carbon::parse($cheque->fecha_vencimiento)->format('d/m/Y') }}</td>
                            <td class="acciones">
                                <a href="{{ route('cheques.show', $cheque->id_cheque) }}" class="btn-secondary">Ver</a>

                                @if(in_array(session('usuario_rol'), ['Operador', 'Supervisor']))
                                    <a href="{{ route('cheques.edit', $cheque->id_cheque) }}" class="btn-edit">Editar</a>
                                @endif

                                @if(session('usuario_rol') === 'Supervisor')
                                    <form action="{{ route('cheques.destroy', $cheque->id_cheque) }}" method="POST" onsubmit="return confirm('¿Eliminar este cheque?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="sin-datos">No Hay Cheques Registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>