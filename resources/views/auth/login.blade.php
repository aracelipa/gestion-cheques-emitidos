<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            min-height: 100vh;
            color: #111827;
            display: flex;
            flex-direction: column;
        }

        .header {
            padding: 22px 32px 0 32px;
        }

        .header .sistema {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            letter-spacing: 0.2px;
        }

        .contenedor-login {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card-login {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .titulo {
            margin: 0 0 6px 0;
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            text-align: center;
        }

        .subtitulo {
            margin: 0 0 22px 0;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 14px;
            margin-bottom: 6px;
            font-weight: bold;
            color: #111827;
        }

        input {
            width: 100%;
            padding: 11px 12px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #70B291;
            box-shadow: 0 0 0 3px rgba(112, 178, 145, 0.15);
        }

        button {
            width: 100%;
            margin-top: 22px;
            padding: 12px;
            background: #70B291;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.2s ease;
        }

        button:hover {
            background: #4F8F73;
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
            .header {
                padding: 18px 20px 0 20px;
            }

            .header .sistema {
                font-size: 16px;
            }

            .contenedor-login {
                padding: 20px;
            }

            .card-login {
                padding: 24px;
            }

            .titulo {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="sistema">Sistema de Gestión de Cheques Emitidos</div>
    </div>

    <div class="contenedor-login">
        <div class="card-login">
            <h1 class="titulo">Iniciar Sesión</h1>
            <p class="subtitulo">Ingrese sus credenciales para continuar.</p>

            @if($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <label for="nickname">Usuario</label>
                <input type="text" name="nickname" id="nickname" value="{{ old('nickname') }}" required>

                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>

                <button type="submit">Ingresar</button>
            </form>
        </div>
    </div>

</body>
</html>