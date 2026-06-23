<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notificacion;

class Cheque extends Model
{
    // tabla y clave primaria
    protected $table = 'cheques';
    protected $primaryKey = 'id_cheque';

    // campos asignables
    protected $fillable = [
        'id_cuenta_bancaria',
        'id_estado_actual',
        'numero_cheque',
        'beneficiario_nombre',
        'beneficiario_email',
        'monto',
        'fecha_emision',
        'fecha_vencimiento',
        'firma_responsable',
        'observaciones',
        'version',
    ];

    // conversión de tipos
    protected $casts = [
        'monto' => 'integer',
        'fecha_emision' => 'date',
        'fecha_vencimiento' => 'date',
        'version' => 'integer',
    ];

    // relación con cuenta bancaria
    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class, 'id_cuenta_bancaria', 'id_cuenta_bancaria');
    }

    // relación con estado actual
    public function estadoActual()
    {
        return $this->belongsTo(EstadoCheque::class, 'id_estado_actual', 'id_estado_cheque');
    }

    // historial del cheque
    public function historialEstados()
    {
        return $this->hasMany(HistorialEstadoCheque::class, 'id_cheque', 'id_cheque');
    }
    
    // notificaciones del cheque
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_cheque', 'id_cheque');
    }

    // bitácora del cheque
    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class, 'id_cheque', 'id_cheque');
    }

    // adjuntos del cheque
    public function adjuntos()
    {
        return $this->hasMany(Adjunto::class, 'id_cheque', 'id_cheque');
    }
}