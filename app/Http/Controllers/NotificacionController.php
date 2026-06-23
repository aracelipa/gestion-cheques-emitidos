<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Throwable;
use App\Models\Notificacion;
use App\Models\Bitacora;
use Carbon\Carbon;  // calcula fechas programadas
use Illuminate\Support\Str; // recorta texto

class NotificacionController extends Controller
{
    // valida supervisor
    private function validarSupervisor()
    {
        if (session('usuario_rol') !== 'Supervisor') {
            abort(403, 'no autorizado');
        }
    }

    // registra bitacora
    private function registrarBitacora($accion, $descripcion, $idCheque = null, $idNotificacion = null)
    {
        Bitacora::create([
            'id_usuario' => session('usuario_id'),
            'id_cheque' => $idCheque,
            'id_notificacion' => $idNotificacion,
            'modulo' => 'NOTIFICACIONES',
            'accion' => $accion,
            'descripcion' => $descripcion,
            'ip_origen' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'fecha_hora_evento' => now(),
        ]);
    }

    // lista notificaciones
    public function index()
    {
        $this->validarSupervisor();

        $notificaciones = Notificacion::with([
            'cheque',
            'usuarioDestino',
            'usuarioVerificador',
        ])
        ->orderBy('id_notificacion', 'desc')
        ->get();

        return view('notificaciones.index', compact('notificaciones'));
    }

    // verifica notificacion del supervisor
    public function verificar($id)
    {
        $this->validarSupervisor();

        $notificacion = Notificacion::with('cheque')->findOrFail($id);

        if ($notificacion->tipo_notificacion !== 'SUPERVISOR_REVISION') {
            return back()->with('error', 'solo se pueden verificar notificaciones de revisión.');
        }

        if ($notificacion->estado === 'Verificada') {
            return back()->with('error', 'la notificación ya fue verificada.');
        }

        $notificacion->update([
            'estado' => 'Verificada',
            'fecha_verificacion' => now(),
            'verificada_por' => session('usuario_id'),
        ]);

        // crea notificacion al beneficiario 3 días antes del vencimiento
        if ($notificacion->cheque && $notificacion->cheque->beneficiario_email) {
            $fechaVencimiento = Carbon::parse($notificacion->cheque->fecha_vencimiento);
            $fechaProgramada = $fechaVencimiento->copy()->subDays(3);

            if ($fechaProgramada->lt(now())) {
                $fechaProgramada = now();
            }

            $existeNotificacionBeneficiario = Notificacion::where('id_cheque', $notificacion->id_cheque)
                ->where('tipo_notificacion', 'BENEFICIARIO_PREVIA')
                ->exists();

            if (!$existeNotificacionBeneficiario) {
                Notificacion::create([
                    'id_cheque' => $notificacion->id_cheque,
                    'id_usuario_destino' => null,
                    'tipo_notificacion' => 'BENEFICIARIO_PREVIA',
                    'destinatario_email' => $notificacion->cheque->beneficiario_email,
                    'asunto' => 'Aviso: su cheque vence en 3 días',
                    'mensaje' => 'Le informamos que su cheque número ' . $notificacion->cheque->numero_cheque . ' vence en 3 días, el ' . $fechaVencimiento->format('d/m/Y') . '.',
                    'estado' => 'Pendiente',
                    'fecha_programada' => $fechaProgramada,
                ]);

                $this->registrarBitacora(
                    'PROGRAMAR',
                    'se programó la notificación al beneficiario para el ' . $fechaProgramada->format('d/m/Y H:i') . '.',
                    $notificacion->id_cheque
                );
            }
        }

        $this->registrarBitacora(
            'VERIFICAR',
            'se verificó la notificación de revisión del cheque.',
            $notificacion->id_cheque,
            $notificacion->id_notificacion
        );

        return redirect()
            ->route('notificaciones.index')
            ->with('success', 'notificación verificada correctamente.');
    }

    // marca notificacion como enviada
    // marca notificacion como enviada
    public function marcarEnviada($id)
    {
        $this->validarSupervisor();

        $notificacion = Notificacion::findOrFail($id);

        if (!$notificacion->destinatario_email) {
            return back()->with('error', 'la notificación no tiene correo destinatario.');
        }

        try {
            Mail::raw($notificacion->mensaje, function ($message) use ($notificacion) {
                $message->to($notificacion->destinatario_email)
                    ->subject($notificacion->asunto);
            });

            $notificacion->update([
                'estado' => 'Enviada',
                'fecha_envio' => now(),
                'intentos' => ($notificacion->intentos ?? 0) + 1,
                'error_mensaje' => null,
            ]);

            $this->registrarBitacora(
                'ENVIAR',
                'se envió la notificación al correo "' . $notificacion->destinatario_email . '".',
                $notificacion->id_cheque,
                $notificacion->id_notificacion
            );

            return redirect()
                ->route('notificaciones.index')
                ->with('success', 'notificación enviada correctamente.');
        } catch (Throwable $e) {
            $errorTexto = Str::limit($e->getMessage(), 240);

            $notificacion->update([
                'estado' => 'Error',
                'intentos' => ($notificacion->intentos ?? 0) + 1,
                'error_mensaje' => $errorTexto,
            ]);

            $this->registrarBitacora(
                'ERROR_ENVIO',
                'falló el envío de la notificación al correo "' . $notificacion->destinatario_email . '".',
                $notificacion->id_cheque,
                $notificacion->id_notificacion
            );

            return redirect()
                ->route('notificaciones.index')
                ->with('error', 'no se pudo enviar el correo. revise la configuración smtp.');
        }
    }
}