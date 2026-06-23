<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCheque extends Model
{
    // tabla y clave primaria
    protected $table = 'estados_cheque';
    protected $primaryKey = 'id_estado_cheque';

    // campos asignables
    protected $fillable = [
        'nombre',
        'tipo_estado',
        'descripcion',
        'activo',
        'orden_flujo',
    ];

    // conversión de booleano
    protected $casts = [
        'activo' => 'boolean',
    ];

    // relación con cheques por estado actual
    public function cheques()
    {
        return $this->hasMany(Cheque::class, 'id_estado_actual', 'id_estado_cheque');
    }

    // relación con historial como estado anterior
    public function historialesComoAnterior()
    {
        return $this->hasMany(HistorialEstadoCheque::class, 'id_estado_anterior', 'id_estado_cheque');
    }

    // relación con historial como estado nuevo
    public function historialesComoNuevo()
    {
        return $this->hasMany(HistorialEstadoCheque::class, 'id_estado_nuevo', 'id_estado_cheque');
    }
}