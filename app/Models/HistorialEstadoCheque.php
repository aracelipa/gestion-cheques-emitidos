<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialEstadoCheque extends Model
{
    // tabla y clave primaria
    protected $table = 'historial_estados_cheque';
    protected $primaryKey = 'id_historial_estado';

    // campos asignables
    protected $fillable = [
        'id_cheque',
        'id_estado_anterior',
        'id_estado_nuevo',
        'id_usuario',
        'id_motivo_rechazo',
        'motivo_texto',
        'es_reversion',
        'fecha_hora_cambio',
    ];

    // conversión de tipos
    protected $casts = [
        'es_reversion' => 'boolean',
        'fecha_hora_cambio' => 'datetime',
    ];

    // relación con cheque
    public function cheque()
    {
        return $this->belongsTo(Cheque::class, 'id_cheque', 'id_cheque');
    }

    // relación con estado anterior
    public function estadoAnterior()
    {
        return $this->belongsTo(EstadoCheque::class, 'id_estado_anterior', 'id_estado_cheque');
    }

    // relación con estado nuevo
    public function estadoNuevo()
    {
        return $this->belongsTo(EstadoCheque::class, 'id_estado_nuevo', 'id_estado_cheque');
    }

    // relación con usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // relación con motivo
    public function motivoRechazo()
    {
        return $this->belongsTo(MotivoRechazo::class, 'id_motivo_rechazo', 'id_motivo_rechazo');
    }

    // adjuntos ligados al historial
    public function adjuntos()
    {
        return $this->hasMany(Adjunto::class, 'id_historial_estado', 'id_historial_estado');
    }
}