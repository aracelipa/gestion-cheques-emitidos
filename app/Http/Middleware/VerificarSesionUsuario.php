<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class VerificarSesionUsuario
{
    // verifica que exista sesión activa
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('usuario_id')) {
            return redirect()->route('login');
        }

        $usuarioId = session('usuario_id');
        $debeCambiarPassword = Cache::has('forzar_cambio_password_' . $usuarioId);

        if (
            $debeCambiarPassword &&
            !$request->routeIs('password.cambiar.form') &&
            !$request->routeIs('password.cambiar.guardar') &&
            !$request->routeIs('logout')
        ) {
            return redirect()->route('password.cambiar.form');
        }

        return $next($request);
    }
}