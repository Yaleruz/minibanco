<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 *
 * @property $id
 * @property $identificacion_cliente
 * @property $Nombres
 * @property $apellidos
 * @property $created_at
 * @property $updated_at
 *
 * @property Cuenta[] $cuentas
 * @property Cuenta[] $cuentas
 * @property Pedido[] $pedidos
 * @property Cuenta[] $cuentas
 * @property Cuenta[] $cuentas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cliente extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['identificacion_cliente', 'Nombres', 'apellidos'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cuentas()
    {
        return $this->hasMany(\App\Models\Cuenta::class, 'id', 'identificacion');
    }
    
 
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos()
    {
        return $this->hasMany(\App\Models\Pedido::class, 'cliente_id', 'cliente_id');
    }
    

}
