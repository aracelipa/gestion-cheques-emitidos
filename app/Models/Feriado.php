<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feriado extends Model
{
    // tabla y clave primaria
    protected $table = 'feriados';
    protected $primaryKey = 'id_feriado';

    // campos asignables
    protected $fillable = [
        'fecha',
        'descripcion',
        'tipo',
        'activo',
    ];

    // conversión de tipos
    protected $casts = [
        'fecha' => 'date',
        'activo' => 'boolean',
    ];
}