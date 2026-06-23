<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    // tabla y clave primaria
    protected $table = 'bancos'; 
    protected $primaryKey = 'id_banco';

    // campos asignables
    protected $fillable = [
        'nombre',
        'codigo',
        'activo',
    ];

    // conversión de booleano
    protected $casts = [
        'activo' => 'boolean',
    ];

    // un banco tiene muchas cuentas
    public function cuentasBancarias()
    {
        return $this->hasMany(CuentaBancaria::class, 'id_banco', 'id_banco');
    }
}