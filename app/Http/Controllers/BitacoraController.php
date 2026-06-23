<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;

class BitacoraController extends Controller
{
    // lista la bitácora más reciente
    public function index()
    {
        // solo supervisor puede ver bitácora
        if (session('usuario_rol') !== 'Supervisor') {
            abort(403, 'no autorizado');
        }

        $bitacoras = Bitacora::with(['usuario', 'cheque', 'notificacion'])
            ->orderBy('fecha_hora_evento', 'desc')
            ->get();

        return view('bitacoras.index', compact('bitacoras'));
    }
}