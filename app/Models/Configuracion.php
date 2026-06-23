<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    // tabla y clave primaria
    protected $table = 'configuraciones';
    protected $primaryKey = 'id_configuracion';

    // campos asignables
    protected $fillable = [
        'clave',
        'valor',
        'descripcion',
        'updated_by',
    ];

    // usuario que actualizó la configuración
    public function usuarioActualizacion()
    {
        return $this->belongsTo(Usuario::class, 'updated_by', 'id_usuario');
    }
}