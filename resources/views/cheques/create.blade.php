<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cheque</title>
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

            .acciones {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="contenedor">
        <h1>Registrar Cheque</h1>

        @if($errors->any())
            <div class="error-box">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <form action="{{ route('cheques.store') }}" method="POST" class="form-principal">
                @csrf

                <label for="id_cuenta_bancaria">Cuenta Bancaria</label>
                <select name="id_cuenta_bancaria" id="id_cuenta_bancaria" required>
                    <option value="">Seleccione una cuenta</option>
                    @foreach($cuentas as $cuenta)
                        <option value="{{ $cuenta->id_cuenta_bancaria }}" {{ old('id_cuenta_bancaria') == $cuenta->id_cuenta_bancaria ? 'selected' : '' }}>
                            {{ $cuenta->banco->nombre ?? 'Sin Banco' }} - {{ $cuenta->numero_cuenta }}
                        </option>
                    @endforeach
                </select>

                <label for="id_estado_actual">Estado Inicial</label>
                <select name="id_estado_actual" id="id_estado_actual" required>
                    <option value="">Seleccione un estado</option>
                    @foreach($estados as $estado)
                        <option value="{{ $estado->id_estado_cheque }}" {{ old('id_estado_actual') == $estado->id_estado_cheque ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>

                <label for="numero_cheque">Número de Cheque</label>
                <input type="text" name="numero_cheque" id="numero_cheque" value="{{ old('numero_cheque') }}" required>

                <label for="beneficiario_nombre">Beneficiario</label>
                <input type="text" name="beneficiario_nombre" id="beneficiario_nombre" value="{{ old('beneficiario_nombre') }}" required>

                <label for="beneficiario_email">Correo del Beneficiario</label>
                <input type="email" name="beneficiario_email" id="beneficiario_email" value="{{ old('beneficiario_email') }}">

                <label for="monto">Monto (Gs.)</label>
                <input type="number" step="1" min="1" name="monto" id="monto" value="{{ old('monto') }}" required>

                <label for="fecha_emision">Fecha de Emisión</label>
                <input type="date" name="fecha_emision" id="fecha_emision" value="{{ old('fecha_emision') }}" required>

                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" required>

                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="4">{{ old('observaciones') }}</textarea>

                <div class="acciones">
                    <button type="submit" class="btn">Guardar</button>
                    <a href="{{ route('cheques.index') }}" class="btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>