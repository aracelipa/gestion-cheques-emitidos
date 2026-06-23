<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    // tabla y clave primaria
    protected $table = 'bitacoras';
    protected $primaryKey = 'id_bitacora';

    // campos asignables
    protected $fillable = [
        'id_usuario',
        'id_cheque',
        'id_notificacion',
        'modulo',
        'accion',
        'descripcion',
        'ip_origen',
        'user_agent',
        'fecha_hora_evento',
    ];

    // conversión de fecha
    protected $casts = [
        'fecha_hora_evento' => 'datetime',
    ];

    // relación con usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // relación con cheque
    public function cheque()
    {
        return $this->belongsTo(Cheque::class, 'id_cheque', 'id_cheque');
    }

    // relación con notificación
    public function notificacion()
    {
        return $this->belongsTo(Notificacion::class, 'id_notificacion', 'id_notificacion');
    }
}