<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
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
            margin: 0;
        }

        label {
            display: block;
            margin-top: 14px;
            margin-bottom: 6px;
            font-weight: bold;
            color: #111827;
        }

        input, select {
            width: 100%;
            padding: 10px 12px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
        }

        input:focus, select:focus {
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
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="contenedor">
        <h1>Registrar Usuario</h1>

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
            <form action="{{ route('usuarios.store') }}" method="POST" class="form-principal">
                @csrf

                <label for="id_rol">Rol</label>
                <select name="id_rol" id="id_rol" required>
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $rol)
                        <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                            {{ $rol->nombre }}
                        </option>
                    @endforeach
                </select>

                <label for="nickname">Nickname</label>
                <input type="text" name="nickname" id="nickname" value="{{ old('nickname') }}" required>

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>

                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" required>

                <label for="email">Correo</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">

                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>

                <label for="estado">Estado</label>
                <select name="estado" id="estado" required>
                    <option value="">Seleccione un estado</option>
                    <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Bloqueado" {{ old('estado') == 'Bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                    <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>

                <div class="acciones">
                    <button type="submit" class="btn">Guardar</button>
                    <a href="{{ route('usuarios.index') }}" class="btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>