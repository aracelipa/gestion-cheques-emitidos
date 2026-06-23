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

    @include('partials.navbar')

    <div class="contenedor">
        <h1>Estado Crítico</h1>

        <div class="card">
            <div class="info-box">
                <strong>Cheque:</strong> {{ $cheque->numero_cheque }} <br>
                <strong>Estado Actual:</strong> {{ $cheque->estadoActual->nombre ?? 'Sin Estado' }} <br>
                <strong>Beneficiario:</strong> {{ $cheque->beneficiario_nombre }}
            </div>

            <div class="warning-box">
                Para los estados <strong>Rechazado</strong> y <strong>Anulado</strong>, debe indicar un motivo.
            </div>

            @if($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cheques.estado_critico.guardar', $cheque->id_cheque) }}" method="POST" class="form-principal">
                @csrf

                <label for="id_estado_nuevo">Nuevo Estado Crítico</label>
                <select name="id_estado_nuevo" id="id_estado_nuevo" required>
                    <option value="">Seleccione un estado</option>
                    @foreach($estadosCriticos as $estado)
                        <option value="{{ $estado->id_estado_cheque }}" {{ old('id_estado_nuevo') == $estado->id_estado_cheque ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>

                <label for="id_motivo_rechazo">Motivo Catalogado</label>
                <select name="id_motivo_rechazo" id="id_motivo_rechazo">
                    <option value="">Seleccione un motivo (opcional)</option>
                    @foreach($motivos as $motivo)
                        <option value="{{ $motivo->id_motivo_rechazo }}" {{ old('id_motivo_rechazo') == $motivo->id_motivo_rechazo ? 'selected' : '' }}>
                            {{ $motivo->descripcion }}
                        </option>
                    @endforeach
                </select>

                <label for="motivo_texto">Detalle del Motivo</label>
                <textarea name="motivo_texto" id="motivo_texto" rows="4">{{ old('motivo_texto') }}</textarea>

                <div class="acciones">
                    <button type="submit" class="btn-edit">Guardar Cambio Crítico</button>
                    <a href="{{ route('cheques.edit', $cheque->id_cheque) }}" class="btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>