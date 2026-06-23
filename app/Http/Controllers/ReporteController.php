<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\EstadoCheque;
use App\Models\Banco;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // genera pdf

class ReporteController extends Controller
{
    // valida supervisor
    private function validarSupervisor()
    {
        if (session('usuario_rol') !== 'Supervisor') {
            abort(403, 'no autorizado');
        }
    }

    // arma consulta base
    private function construirConsulta(Request $request)
    {
        $query = Cheque::with([
            'cuentaBancaria.banco',
            'estadoActual',
        ]);

        if ($request->filled('id_estado_actual')) {
            $query->where('id_estado_actual', $request->id_estado_actual);
        }

        if ($request->filled('beneficiario_nombre')) {
            $query->where('beneficiario_nombre', 'ilike', '%' . $request->beneficiario_nombre . '%');
        }

        if ($request->filled('id_banco')) {
            $query->whereHas('cuentaBancaria', function ($subquery) use ($request) {
                $subquery->where('id_banco', $request->id_banco);
            });
        }

        if ($request->filled('fecha_vencimiento_desde')) {
            $query->whereDate('fecha_vencimiento', '>=', $request->fecha_vencimiento_desde);
        }

        if ($request->filled('fecha_vencimiento_hasta')) {
            $query->whereDate('fecha_vencimiento', '<=', $request->fecha_vencimiento_hasta);
        }

        return $query->orderBy('fecha_vencimiento', 'asc');
    }

    // vista principal de reportes
    public function index(Request $request)
    {
        $this->validarSupervisor();

        $cheques = $this->construirConsulta($request)->get();
        $estados = EstadoCheque::orderBy('nombre')->get();
        $bancos = Banco::orderBy('nombre')->get();

        return view('reportes.index', compact('cheques', 'estados', 'bancos'));
    }

    // exporta reporte a pdf
    public function pdf(Request $request)
    {
        $this->validarSupervisor();

        $cheques = $this->construirConsulta($request)->get();

        $pdf = Pdf::loadView('reportes.pdf', compact('cheques'));

        return $pdf->download('reporte_cheques.pdf');
    }
}