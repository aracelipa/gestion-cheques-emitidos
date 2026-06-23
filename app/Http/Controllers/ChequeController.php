<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\CuentaBancaria;
use App\Models\EstadoCheque;
use App\Models\HistorialEstadoCheque;
use App\Models\Bitacora;
use App\Models\MotivoRechazo;
use App\Models\Notificacion;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    // registra bitácora
    private function registrarBitacora($accion, $descripcion, $idCheque = null)
    {
        Bitacora::create([
            'id_usuario' => session('usuario_id'),
            'id_cheque' => $idCheque,
            'id_notificacion' => null,
            'modulo' => 'CHEQUES',
            'accion' => $accion,
            'descripcion' => $descripcion,
            'ip_origen' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'fecha_hora_evento' => now(),
        ]);
    }

    // formato monto
    private function formatearMonto($monto)
    {
        return '₲ ' . number_format($monto, 0, ',', '.');
    }

    // obtiene nombre estado
    private function obtenerNombreEstado($idEstado)
    {
        return EstadoCheque::where('id_estado_cheque', $idEstado)->value('nombre') ?? 'sin estado';
    }

    // obtiene cuenta visible
    private function obtenerCuentaVisible($idCuenta)
    {
        $cuenta = CuentaBancaria::with('banco')->find($idCuenta);

        if (!$cuenta) {
            return 'sin cuenta';
        }

        return ($cuenta->banco->nombre ?? 'sin banco') . ' - ' . $cuenta->numero_cuenta;
    }

    // construye detalle de cambios
    private function construirDescripcionCambiosCheque($cheque, $request)
    {
        $cambios = [];

        if ($cheque->id_cuenta_bancaria != $request->id_cuenta_bancaria) {
            $cambios[] = 'se cambió cuenta bancaria de "' . $this->obtenerCuentaVisible($cheque->id_cuenta_bancaria) . '" a "' . $this->obtenerCuentaVisible($request->id_cuenta_bancaria) . '"';
        }

        if ($cheque->numero_cheque !== $request->numero_cheque) {
            $cambios[] = 'se cambió número de cheque de "' . $cheque->numero_cheque . '" a "' . $request->numero_cheque . '"';
        }

        if ($cheque->beneficiario_nombre !== $request->beneficiario_nombre) {
            $cambios[] = 'se cambió beneficiario de "' . $cheque->beneficiario_nombre . '" a "' . $request->beneficiario_nombre . '"';
        }

        if (($cheque->beneficiario_email ?? '') !== ($request->beneficiario_email ?? '')) {
            $cambios[] = 'se cambió correo del beneficiario de "' . ($cheque->beneficiario_email ?? 'sin correo') . '" a "' . ($request->beneficiario_email ?? 'sin correo') . '"';
        }

        if ((int) $cheque->monto !== (int) $request->monto) {
            $cambios[] = 'se cambió monto de ' . $this->formatearMonto($cheque->monto) . ' a ' . $this->formatearMonto($request->monto);
        }

        $fechaEmisionAnterior = \Carbon\Carbon::parse($cheque->fecha_emision)->format('d/m/Y');
        $fechaEmisionNueva = \Carbon\Carbon::parse($request->fecha_emision)->format('d/m/Y');

        if ($fechaEmisionAnterior !== $fechaEmisionNueva) {
            $cambios[] = 'se cambió fecha de emisión de ' . $fechaEmisionAnterior . ' a ' . $fechaEmisionNueva;
        }

        $fechaVencimientoAnterior = \Carbon\Carbon::parse($cheque->fecha_vencimiento)->format('d/m/Y');
        $fechaVencimientoNueva = \Carbon\Carbon::parse($request->fecha_vencimiento)->format('d/m/Y');

        if ($fechaVencimientoAnterior !== $fechaVencimientoNueva) {
            $cambios[] = 'se cambió fecha de vencimiento de ' . $fechaVencimientoAnterior . ' a ' . $fechaVencimientoNueva;
        }

        if (($cheque->observaciones ?? '') !== ($request->observaciones ?? '')) {
            $cambios[] = 'se actualizaron observaciones';
        }

        if ((int) $cheque->id_estado_actual !== (int) $request->id_estado_actual) {
            $cambios[] = 'se cambió estado de "' . $this->obtenerNombreEstado($cheque->id_estado_actual) . '" a "' . $this->obtenerNombreEstado($request->id_estado_actual) . '"';
        }

        if (empty($cambios)) {
            return 'no hubo cambios visibles en el cheque "' . $cheque->numero_cheque . '".';
        }

        return implode('; ', $cambios) . '.';
    }

    // lista de cheques
    public function index()
    {
        $cheques = Cheque::with(['cuentaBancaria.banco', 'estadoActual'])
            ->orderBy('id_cheque', 'desc')
            ->get();

        return view('cheques.index', compact('cheques'));
    }

    // formulario de creación
    public function create()
    {
        if (session('usuario_rol') !== 'Operador') {
            abort(403, 'no autorizado');
        }

        $cuentas = CuentaBancaria::with('banco')
            ->where('estado', 'Activa')
            ->orderBy('numero_cuenta')
            ->get();

        $estados = EstadoCheque::where('tipo_estado', 'Normal')
            ->orderBy('orden_flujo')
            ->get();

        return view('cheques.create', compact('cuentas', 'estados'));
    }

    // guarda cheque nuevo
    public function store(Request $request)
    {
        if (session('usuario_rol') !== 'Operador') {
            abort(403, 'no autorizado');
        }

        $request->validate([
            'id_cuenta_bancaria' => 'required|exists:cuentas_bancarias,id_cuenta_bancaria',
            'id_estado_actual' => 'required|exists:estados_cheque,id_estado_cheque',
            'numero_cheque' => 'required|string|max:30',
            'beneficiario_nombre' => 'required|string|max:150',
            'beneficiario_email' => 'nullable|email|max:150',
            'monto' => 'required|integer|min:1',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'observaciones' => 'nullable|string',
        ], [
            'id_cuenta_bancaria.required' => 'la cuenta bancaria es obligatoria.',
            'id_estado_actual.required' => 'el estado inicial es obligatorio.',
            'numero_cheque.required' => 'el número de cheque es obligatorio.',
            'beneficiario_nombre.required' => 'el beneficiario es obligatorio.',
            'beneficiario_email.email' => 'el correo del beneficiario no es válido.',
            'monto.required' => 'el monto es obligatorio.',
            'monto.integer' => 'el monto debe ingresarse sin decimales.',
            'monto.min' => 'el monto debe ser mayor o igual a 1.',
            'fecha_emision.required' => 'la fecha de emisión es obligatoria.',
            'fecha_emision.date' => 'la fecha de emisión no es válida.',
            'fecha_vencimiento.required' => 'la fecha de vencimiento es obligatoria.',
            'fecha_vencimiento.date' => 'la fecha de vencimiento no es válida.',
            'fecha_vencimiento.after_or_equal' => 'la fecha de vencimiento no puede ser menor que la fecha de emisión.',
        ]);

        $existe = Cheque::where('id_cuenta_bancaria', $request->id_cuenta_bancaria)
            ->where('numero_cheque', $request->numero_cheque)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'numero_cheque' => 'ya existe un cheque con ese número en la cuenta seleccionada.',
                ]);
        }

        $cheque = Cheque::create([
            'id_cuenta_bancaria' => $request->id_cuenta_bancaria,
            'id_estado_actual' => $request->id_estado_actual,
            'numero_cheque' => $request->numero_cheque,
            'beneficiario_nombre' => $request->beneficiario_nombre,
            'beneficiario_email' => $request->beneficiario_email,
            'monto' => $request->monto,
            'fecha_emision' => $request->fecha_emision,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'firma_responsable' => session('usuario_nombre'),
            'observaciones' => $request->observaciones,
            'version' => 1,
        ]);

        HistorialEstadoCheque::create([
            'id_cheque' => $cheque->id_cheque,
            'id_estado_anterior' => null,
            'id_estado_nuevo' => $request->id_estado_actual,
            'id_usuario' => session('usuario_id'),
            'id_motivo_rechazo' => null,
            'motivo_texto' => 'registro inicial del cheque',
            'es_reversion' => false,
            'fecha_hora_cambio' => now(),
        ]);

        // crea notificacion inicial para supervisor
        Notificacion::create([
            'id_cheque' => $cheque->id_cheque,
            'id_usuario_destino' => null,
            'tipo_notificacion' => 'SUPERVISOR_REVISION',
            'destinatario_email' => null,
            'asunto' => 'Revisión de cheque registrado',
            'mensaje' => 'Se registró el cheque número ' . $cheque->numero_cheque . ' y requiere revisión previa del supervisor.',
            'estado' => 'Pendiente',
            'fecha_programada' => now(),
        ]);

        $this->registrarBitacora(
            'CREAR',
            'se registró el cheque "' . $cheque->numero_cheque . '" para "' . $cheque->beneficiario_nombre . '" por ' . $this->formatearMonto($cheque->monto) . '.',
            $cheque->id_cheque
        );

        return redirect()
            ->route('cheques.index')
            ->with('success', 'cheque registrado correctamente.');
    }

    // formulario de edición
    public function edit($id)
    {
        if (!in_array(session('usuario_rol'), ['Operador', 'Supervisor'])) {
            abort(403, 'no autorizado');
        }

        $cheque = Cheque::findOrFail($id);

        $cuentas = CuentaBancaria::with('banco')
            ->where('estado', 'Activa')
            ->orderBy('numero_cuenta')
            ->get();

        $estados = EstadoCheque::where('tipo_estado', 'Normal')
            ->orderBy('orden_flujo')
            ->get();

        return view('cheques.edit', compact('cheque', 'cuentas', 'estados'));
    }

    // actualiza cheque
    public function update(Request $request, $id)
    {
        if (!in_array(session('usuario_rol'), ['Operador', 'Supervisor'])) {
            abort(403, 'no autorizado');
        }

        $cheque = Cheque::findOrFail($id);
        $estadoAnterior = $cheque->id_estado_actual;

        $request->validate([
            'id_cuenta_bancaria' => 'required|exists:cuentas_bancarias,id_cuenta_bancaria',
            'id_estado_actual' => 'required|exists:estados_cheque,id_estado_cheque',
            'numero_cheque' => 'required|string|max:30',
            'beneficiario_nombre' => 'required|string|max:150',
            'beneficiario_email' => 'nullable|email|max:150',
            'monto' => 'required|integer|min:1',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'observaciones' => 'nullable|string',
        ], [
            'id_cuenta_bancaria.required' => 'la cuenta bancaria es obligatoria.',
            'id_estado_actual.required' => 'el estado es obligatorio.',
            'numero_cheque.required' => 'el número de cheque es obligatorio.',
            'beneficiario_nombre.required' => 'el beneficiario es obligatorio.',
            'beneficiario_email.email' => 'el correo del beneficiario no es válido.',
            'monto.required' => 'el monto es obligatorio.',
            'monto.integer' => 'el monto debe ingresarse sin decimales.',
            'monto.min' => 'el monto debe ser mayor o igual a 1.',
            'fecha_emision.required' => 'la fecha de emisión es obligatoria.',
            'fecha_emision.date' => 'la fecha de emisión no es válida.',
            'fecha_vencimiento.required' => 'la fecha de vencimiento es obligatoria.',
            'fecha_vencimiento.date' => 'la fecha de vencimiento no es válida.',
            'fecha_vencimiento.after_or_equal' => 'la fecha de vencimiento no puede ser menor que la fecha de emisión.',
        ]);

        $estadoNuevo = EstadoCheque::findOrFail($request->id_estado_actual);

        if ($estadoNuevo->tipo_estado === 'Critico') {
            return back()
                ->withInput()
                ->withErrors([
                    'id_estado_actual' => 'los estados críticos solo pueden cambiarse desde la opción "estado crítico".',
                ]);
        }

        $existe = Cheque::where('id_cuenta_bancaria', $request->id_cuenta_bancaria)
            ->where('numero_cheque', $request->numero_cheque)
            ->where('id_cheque', '!=', $cheque->id_cheque)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'numero_cheque' => 'ya existe un cheque con ese número en la cuenta seleccionada.',
                ]);
        }

        $descripcion = $this->construirDescripcionCambiosCheque($cheque, $request);

        $cheque->update([
            'id_cuenta_bancaria' => $request->id_cuenta_bancaria,
            'id_estado_actual' => $request->id_estado_actual,
            'numero_cheque' => $request->numero_cheque,
            'beneficiario_nombre' => $request->beneficiario_nombre,
            'beneficiario_email' => $request->beneficiario_email,
            'monto' => $request->monto,
            'fecha_emision' => $request->fecha_emision,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'observaciones' => $request->observaciones,
            'version' => $cheque->version + 1,
        ]);

        if ((int) $estadoAnterior !== (int) $request->id_estado_actual) {
            HistorialEstadoCheque::create([
                'id_cheque' => $cheque->id_cheque,
                'id_estado_anterior' => $estadoAnterior,
                'id_estado_nuevo' => $request->id_estado_actual,
                'id_usuario' => session('usuario_id'),
                'id_motivo_rechazo' => null,
                'motivo_texto' => 'actualización manual del estado',
                'es_reversion' => false,
                'fecha_hora_cambio' => now(),
            ]);

            // crea notificacion para supervisor por cambio de estado normal
            Notificacion::create([
                'id_cheque' => $cheque->id_cheque,
                'id_usuario_destino' => null,
                'tipo_notificacion' => 'SUPERVISOR_REVISION',
                'destinatario_email' => null,
                'asunto' => 'Revisión de cambio de cheque',
                'mensaje' => 'El cheque número ' . $cheque->numero_cheque . ' tuvo un cambio de estado normal y requiere revisión del supervisor.',
                'estado' => 'Pendiente',
                'fecha_programada' => now(),
            ]);

        }

        $this->registrarBitacora('ACTUALIZAR', $descripcion, $cheque->id_cheque);

        return redirect()
            ->route('cheques.index')
            ->with('success', 'cheque actualizado correctamente.');
    }

    // elimina cheque
    public function destroy($id)
    {
        if (session('usuario_rol') !== 'Supervisor') {
            abort(403, 'no autorizado');
        }

        $cheque = Cheque::findOrFail($id);
        $idCheque = $cheque->id_cheque;
        $numeroCheque = $cheque->numero_cheque;
        $beneficiario = $cheque->beneficiario_nombre;

        $cheque->delete();

        $this->registrarBitacora(
            'ELIMINAR',
            'se eliminó el cheque "' . $numeroCheque . '" del beneficiario "' . $beneficiario . '".',
            $idCheque
        );

        return redirect()
            ->route('cheques.index')
            ->with('success', 'cheque eliminado correctamente.');
    }

    // detalle del cheque
    public function show($id)
    {
        $cheque = Cheque::with([
            'cuentaBancaria.banco',
            'estadoActual',
            'historialEstados' => function ($query) {
                $query->with(['estadoAnterior', 'estadoNuevo', 'motivoRechazo', 'usuario'])
                    ->orderBy('fecha_hora_cambio', 'desc');
            },
        ])->findOrFail($id);

        return view('cheques.show', compact('cheque'));
    }

    // formulario de estado crítico
    public function estadoCritico($id)
    {
        if (session('usuario_rol') !== 'Supervisor') {
            abort(403, 'no autorizado');
        }

        $cheque = Cheque::with(['estadoActual'])->findOrFail($id);

        $estadosCriticos = EstadoCheque::where('tipo_estado', 'Critico')
            ->orderBy('orden_flujo')
            ->get();

        $motivos = MotivoRechazo::where('activo', true)
            ->orderBy('descripcion')
            ->get();

        return view('cheques.estado_critico', compact('cheque', 'estadosCriticos', 'motivos'));
    }

    // guarda el cambio crítico
    public function guardarEstadoCritico(Request $request, $id)
    {
        if (session('usuario_rol') !== 'Supervisor') {
            abort(403, 'no autorizado');
        }

        $cheque = Cheque::findOrFail($id);
        $estadoAnterior = $cheque->id_estado_actual;

        $request->validate([
            'id_estado_nuevo' => 'required|exists:estados_cheque,id_estado_cheque',
            'id_motivo_rechazo' => 'nullable|exists:motivos_rechazo,id_motivo_rechazo',
            'motivo_texto' => 'nullable|string|max:250',
        ]);

        $estadoNuevo = EstadoCheque::findOrFail($request->id_estado_nuevo);

        if ($estadoNuevo->tipo_estado !== 'Critico') {
            return back()
                ->withInput()
                ->withErrors([
                    'id_estado_nuevo' => 'el estado seleccionado no es crítico.',
                ]);
        }

        if (in_array($estadoNuevo->nombre, ['Rechazado', 'Anulado'])) {
            if (!$request->id_motivo_rechazo && !$request->motivo_texto) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'motivo_texto' => 'debes indicar un motivo para rechazo o anulación.',
                    ]);
            }
        }

        $cheque->update([
            'id_estado_actual' => $estadoNuevo->id_estado_cheque,
            'version' => $cheque->version + 1,
        ]);

        HistorialEstadoCheque::create([
            'id_cheque' => $cheque->id_cheque,
            'id_estado_anterior' => $estadoAnterior,
            'id_estado_nuevo' => $estadoNuevo->id_estado_cheque,
            'id_usuario' => session('usuario_id'),
            'id_motivo_rechazo' => $request->id_motivo_rechazo,
            'motivo_texto' => $request->motivo_texto,
            'es_reversion' => false,
            'fecha_hora_cambio' => now(),
        ]);

        $descripcion = 'se cambió estado crítico de "' . $this->obtenerNombreEstado($estadoAnterior) . '" a "' . $estadoNuevo->nombre . '"';

        if ($request->filled('id_motivo_rechazo') || $request->filled('motivo_texto')) {
            $motivoCatalogado = null;

            if ($request->filled('id_motivo_rechazo')) {
                $motivoCatalogado = MotivoRechazo::where('id_motivo_rechazo', $request->id_motivo_rechazo)->value('descripcion');
            }

            $detalleMotivo = $request->motivo_texto ?? null;

            $partesMotivo = [];
            if ($motivoCatalogado) {
                $partesMotivo[] = 'motivo catalogado: "' . $motivoCatalogado . '"';
            }
            if ($detalleMotivo) {
                $partesMotivo[] = 'detalle: "' . $detalleMotivo . '"';
            }

            if (!empty($partesMotivo)) {
                $descripcion .= '; ' . implode('; ', $partesMotivo);
            }
        }

        $descripcion .= '.';

        $this->registrarBitacora('CAMBIO_CRITICO', $descripcion, $cheque->id_cheque);

        return redirect()
            ->route('cheques.show', $cheque->id_cheque)
            ->with('success', 'estado crítico actualizado correctamente.');
    }
}