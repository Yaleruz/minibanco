<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retiro extends Model
{
    protected $table = 'cuentas';
    protected $fillable = ['cuenta_id', 'monto'];

    // Relación con cliente
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'identificacion', 'id');
    }

    // Relación con tipo de cuenta
    public function tipoCuenta()
    {
        return $this->belongsTo(\App\Models\TipoCuenta::class, 'tipo_cuenta', 'id');
    }
}
