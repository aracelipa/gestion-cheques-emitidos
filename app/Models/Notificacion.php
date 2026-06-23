<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';

    protected $fillable = [
        'id_cheque',
        'id_usuario_destino',
        'tipo_notificacion',
        'destinatario_email',
        'asunto',
        'mensaje',
        'estado',
        'fecha_programada',
        'fecha_envio',
        'fecha_verificacion',
        'verificada_por',
        'intentos',
        'error_mensaje',
    ];

    protected $casts = [
        'fecha_programada' => 'datetime',
        'fecha_envio' => 'datetime',
        'fecha_verificacion' => 'datetime',
    ];

    // relacion con cheque
    public function cheque()
    {
        return $this->belongsTo(Cheque::class, 'id_cheque', 'id_cheque');
    }

    // relacion con usuario destino
    public function usuarioDestino()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_destino', 'id_usuario');
    }

    // relacion con usuario verificador
    public function usuarioVerificador()
    {
        return $this->belongsTo(Usuario::class, 'verificada_por', 'id_usuario');
    }
}