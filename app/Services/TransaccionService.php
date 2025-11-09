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
        if ($cuenta->saldo < $monto) {
            throw new \Exception('Fondos insuficientes');
        }

        // Ejecutar procedimiento almacenado
        DB::statement('CALL RealizarRetiro(?, ?, @nuevo_saldo)', [$cuentaId, $monto]);
        
        // Obtener el nuevo saldo
        $result = DB::select('SELECT @nuevo_saldo as nuevo_saldo');
        $nuevoSaldo = $result[0]->nuevo_saldo;

        return [
            'success' => true,
            'cuenta_id' => $cuentaId,
            'monto_retirado' => $monto,
            'nuevo_saldo' => $nuevoSaldo,
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
            'cliente' => $cuenta->cliente->nombres . ' ' . $cuenta->cliente->apellidos,
            'tipo_cuenta' => $cuenta->tipoCuenta->nombre,
            'saldo_actual' => $cuenta->saldo,
            'numero_cuenta' => $cuenta->id
        ];
    }
}