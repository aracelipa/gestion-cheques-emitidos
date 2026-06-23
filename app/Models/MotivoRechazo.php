<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivoRechazo extends Model
{
    // tabla y clave primaria
    protected $table = 'motivos_rechazo';
    protected $primaryKey = 'id_motivo_rechazo';

    // campos asignables
    protected $fillable = [
        'codigo',
        'descripcion',
        'activo',
    ];

    // conversión de booleano
    protected $casts = [
        'activo' => 'boolean',
    ];

    // relación con historial de estados
    public function historialEstados()
    {
        return $this->hasMany(HistorialEstadoCheque::class, 'id_motivo_rechazo', 'id_motivo_rechazo');
    }
}