<?php

namespace App\Services;

use App\Models\Cuenta;
use Illuminate\Support\Facades\DB;

class TransaccionService
{
    /**
     * Realizar retiro usando el procedimiento almacenado
     * Método de negocio: Validar y procesar retiro
     */
    public function realizarRetiro($cuentaId, $monto)
{
    // Validar que la cuenta existe
    $cuenta = Cuenta::find($cuentaId);
    if (!$cuenta) {
        throw new \Exception('Cuenta no encontrada');
    }

    // Validar fondos suficientes 
    if ($cuenta->saldo_cuenta < $monto) {
        throw new \Exception('Fondos insuficientes');
    }

    // Actualizar saldo 
    $cuenta->saldo_cuenta -= $monto;
    $cuenta->save();

    return [
        'success' => true,
        'cuenta_id' => $cuenta->id,
        'monto_retirado' => $monto,
        'nuevo_saldo' => $cuenta->saldo_cuenta, 
        'fecha' => now()->format('Y-m-d H:i:s')
    ];
}

    /**
     * Consultar saldo de cuenta
     */
    public function consultarSaldo($cuentaId)
{
    $cuenta = Cuenta::with('cliente', 'tipoCuenta')->find($cuentaId);
    
    if (!$cuenta) {
        throw new \Exception('Cuenta no encontrada');
    }

    return [
        'cliente' => $cuenta->cliente->Nombres . ' ' . $cuenta->cliente->apellidos, 
        'tipo_cuenta' => $cuenta->tipoCuenta->tipo, 
        'saldo_actual' => $cuenta->saldo_cuenta, 
        'numero_cuenta' => $cuenta->id
    ];
}


}