<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    // tabla y clave primaria
    protected $table = 'cuentas_bancarias';
    protected $primaryKey = 'id_cuenta_bancaria';

    // campos asignables
    protected $fillable = [
        'id_banco',
        'numero_cuenta',
        'titular',
        'estado',
    ];

    // relación con banco
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'id_banco', 'id_banco');
    }

    // una cuenta tiene muchos cheques
    public function cheques()
    {
        return $this->hasMany(Cheque::class, 'id_cuenta_bancaria', 'id_cuenta_bancaria');
    }
}