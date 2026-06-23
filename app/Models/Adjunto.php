<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adjunto extends Model
{
    // tabla y clave primaria
    protected $table = 'adjuntos';
    protected $primaryKey = 'id_adjunto';

    // campos asignables
    protected $fillable = [
        'id_cheque',
        'id_historial_estado',
        'nombre_archivo',
        'ruta_archivo',
        'mime_type',
        'tamano_bytes',
        'tipo_adjunto',
    ];

    // conversión de tipo numérico
    protected $casts = [
        'tamano_bytes' => 'integer',
    ];

    // relación con cheque
    public function cheque()
    {
        return $this->belongsTo(Cheque::class, 'id_cheque', 'id_cheque');
    }

    // relación con historial
    public function historialEstado()
    {
        return $this->belongsTo(HistorialEstadoCheque::class, 'id_historial_estado', 'id_historial_estado');
    }
}