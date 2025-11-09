<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoCuenta
 *
 * @property $id
 * @property $tipo
 * @property $created_at
 * @property $updated_at
 *
 * @property Cuenta[] $cuentas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TipoCuenta extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['tipo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cuentas()
    {
        return $this->hasMany(\App\Models\Cuenta::class, 'tipo_cuenta');
    }
    
}
