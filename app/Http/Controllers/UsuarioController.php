<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UsuarioController extends Controller
{
    // valida rol admin
    private function validarAdministrador()
    {
        if (session('usuario_rol') !== 'Administrador') {
            abort(403, 'no autorizado');
        }
    }

    // registra bitácora
    private function registrarBitacora($accion, $descripcion)
    {
        Bitacora::create([
            'id_usuario' => session('usuario_id'),
            'id_cheque' => null,
            'id_notificacion' => null,
            'modulo' => 'USUARIOS',
            'accion' => $accion,
            'descripcion' => $descripcion,
            'ip_origen' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'fecha_hora_evento' => now(),
        ]);
    }

    // obtiene nombre de rol
    private function obtenerNombreRol($idRol)
    {
        return Rol::where('id_rol', $idRol)->value('nombre') ?? 'sin rol';
    }

    // construye detalle de cambios
    private function construirDescripcionCambiosUsuario($usuario, $request)
    {
        $cambios = [];

        if ($usuario->id_rol != $request->id_rol) {
            $cambios[] = 'se cambió rol de ' . $this->obtenerNombreRol($usuario->id_rol) . ' a ' . $this->obtenerNombreRol($request->id_rol);
        }

        if ($usuario->nickname !== $request->nickname) {
            $cambios[] = 'se cambió nickname de "' . $usuario->nickname . '" a "' . $request->nickname . '"';
        }

        if ($usuario->nombre !== $request->nombre) {
            $cambios[] = 'se cambió nombre de "' . $usuario->nombre . '" a "' . $request->nombre . '"';
        }

        if ($usuario->apellido !== $request->apellido) {
            $cambios[] = 'se cambió apellido de "' . $usuario->apellido . '" a "' . $request->apellido . '"';
        }

        if (($usuario->email ?? '') !== ($request->email ?? '')) {
            $cambios[] = 'se cambió correo de "' . ($usuario->email ?? 'sin correo') . '" a "' . ($request->email ?? 'sin correo') . '"';
        }

        if ($usuario->estado !== $request->estado) {
            $cambios[] = 'se cambió estado de ' . $usuario->estado . ' a ' . $request->estado;
        }

        if ($request->filled('password')) {
            $$cambios[] = 'se restableció la contraseña del usuario "' . $usuario->nickname . '"';
        }

        if (empty($cambios)) {
            return 'no hubo cambios visibles en el usuario: ' . $usuario->nickname;
        }

        return implode('; ', $cambios) . '.';
    }

    // lista usuarios
    public function index()
    {
        $this->validarAdministrador();

        $usuarios = Usuario::with('rol')
            ->orderBy('id_usuario', 'desc')
            ->get();

        return view('usuarios.index', compact('usuarios'));
    }

    // formulario crear
    public function create()
    {
        $this->validarAdministrador();

        $roles = Rol::orderBy('nombre')->get();

        return view('usuarios.create', compact('roles'));
    }

    // guarda usuario
    public function store(Request $request)
    {
        $this->validarAdministrador();

        $request->validate([
            'id_rol' => 'required|exists:roles,id_rol',
            'nickname' => 'required|string|max:50|unique:usuarios,nickname',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
            'password' => 'required|string|min:8',
            'estado' => 'required|in:Activo,Bloqueado,Inactivo',
        ], [
            'id_rol.required' => 'el rol es obligatorio.',
            'nickname.required' => 'el nickname es obligatorio.',
            'nombre.required' => 'el nombre es obligatorio.',
            'apellido.required' => 'el apellido es obligatorio.',
            'email.email' => 'el correo no es válido.',
            'password.required' => 'la contraseña es obligatoria.',
            'password.min' => 'la contraseña debe tener al menos 8 caracteres.',
            'estado.required' => 'el estado es obligatorio.',
        ]);

        $usuario = Usuario::create([
            'id_rol' => $request->id_rol,
            'nickname' => $request->nickname,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'estado' => $request->estado,
        ]);

        Cache::forever('forzar_cambio_password_' . $usuario->id_usuario, true);

        $this->registrarBitacora(
            'CREAR',
            'se registró el usuario "' . $usuario->nickname . '" con rol ' . $this->obtenerNombreRol($usuario->id_rol) . ' y estado ' . $usuario->estado . '.'
        );

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'usuario registrado correctamente.');
    }

    // formulario editar
    public function edit($id)
    {
        $this->validarAdministrador();

        $usuario = Usuario::findOrFail($id);
        $roles = Rol::orderBy('nombre')->get();

        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    // actualiza usuario
    public function update(Request $request, $id)
    {
        $this->validarAdministrador();

        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'id_rol' => 'required|exists:roles,id_rol',
            'nickname' => 'required|string|max:50|unique:usuarios,nickname,' . $usuario->id_usuario . ',id_usuario',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
            'password' => 'nullable|string|min:8',
            'estado' => 'required|in:Activo,Bloqueado,Inactivo',
        ], [
            'id_rol.required' => 'el rol es obligatorio.',
            'nickname.required' => 'el nickname es obligatorio.',
            'nombre.required' => 'el nombre es obligatorio.',
            'apellido.required' => 'el apellido es obligatorio.',
            'email.email' => 'el correo no es válido.',
            'password.min' => 'la contraseña debe tener al menos 8 caracteres.',
            'estado.required' => 'el estado es obligatorio.',
        ]);

        $descripcion = $this->construirDescripcionCambiosUsuario($usuario, $request);

        $datos = [
            'id_rol' => $request->id_rol,
            'nickname' => $request->nickname,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'estado' => $request->estado,
        ];

        if ($request->filled('password')) {
            $datos['password_hash'] = Hash::make($request->password);
            Cache::forever('forzar_cambio_password_' . $usuario->id_usuario, true);
        }

        $usuario->update($datos);

        $this->registrarBitacora('ACTUALIZAR', $descripcion);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'usuario actualizado correctamente.');
    }
}