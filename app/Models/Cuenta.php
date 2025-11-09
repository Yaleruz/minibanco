<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cuenta
 *
 * @property $id
 * @property $identificacion
 * @property $tipo_cuenta
 * @property $saldo_cuenta
 * @property $created_at
 * @property $updated_at
 *
 * @property Cliente $cliente
 * @property TipoCuenta $tipoCuenta
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cuenta extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['identificacion', 'tipo_cuenta', 'saldo_cuenta'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'identificacion', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoCuenta()
    {
        return $this->belongsTo(\App\Models\TipoCuenta::class, 'tipo_cuenta', 'id');
    }
    
}
