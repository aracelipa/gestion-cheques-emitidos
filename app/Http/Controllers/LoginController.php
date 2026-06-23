<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    // muestra el formulario
    public function index()
    {
        return view('auth.login');
    }

    // procesa el login
    public function login(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string',
            'password' => 'required|string',
        ], [
            'nickname.required' => 'el usuario es obligatorio.',
            'password.required' => 'la contraseña es obligatoria.',
        ]);

        $usuario = Usuario::with('rol')
            ->where('nickname', $request->nickname)
            ->where('estado', 'Activo')
            ->first();

        if (!$usuario) {
            return back()->withErrors([
                'nickname' => 'usuario no encontrado o inactivo.',
            ])->withInput();
        }

        if (!Hash::check($request->password, $usuario->password_hash)) {
            return back()->withErrors([
                'password' => 'contraseña incorrecta.',
            ])->withInput();
        }

        session([
            'usuario_id' => $usuario->id_usuario,
            'usuario_nombre' => $usuario->nombre . ' ' . $usuario->apellido,
            'usuario_nickname' => $usuario->nickname,
            'usuario_rol' => $usuario->rol->nombre ?? null,
        ]);

        if (Cache::has('forzar_cambio_password_' . $usuario->id_usuario)) {
            return redirect()->route('password.cambiar.form');
        }

        return redirect()->route('panel.index');
    }

    // muestra formulario de cambio de contraseña
    public function mostrarFormularioCambioPassword()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->route('login');
        }

        return view('auth.cambiar_password');
    }

    // guarda nueva contraseña
    public function cambiarPassword(Request $request)
    {
        if (!session()->has('usuario_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'password_actual' => 'required|string',
            'password_nueva' => 'required|string|min:8|different:password_actual',
            'password_nueva_confirmation' => 'required|same:password_nueva',
        ], [
            'password_actual.required' => 'la contraseña actual es obligatoria.',
            'password_nueva.required' => 'la nueva contraseña es obligatoria.',
            'password_nueva.min' => 'la nueva contraseña debe tener al menos 8 caracteres.',
            'password_nueva.different' => 'la nueva contraseña debe ser diferente de la actual.',
            'password_nueva_confirmation.required' => 'debe confirmar la nueva contraseña.',
            'password_nueva_confirmation.same' => 'la confirmación de la nueva contraseña no coincide.',
        ]);

        $usuario = Usuario::findOrFail(session('usuario_id'));

        if (!Hash::check($request->password_actual, $usuario->password_hash)) {
            return back()->withErrors([
                'password_actual' => 'la contraseña actual es incorrecta.',
            ]);
        }

        $usuario->update([
            'password_hash' => Hash::make($request->password_nueva),
        ]);

        Cache::forget('forzar_cambio_password_' . $usuario->id_usuario);

        return redirect()
            ->route('panel.index')
            ->with('success', 'contraseña actualizada correctamente.');
    }

    // cierra sesión
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}