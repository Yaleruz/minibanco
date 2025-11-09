<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  // ← CORREGIR ESTA LÍNEA
use App\Models\Cuenta;
use Illuminate\Support\Facades\DB;

class SoapController extends Controller
{
    /**
     * Manejar solicitudes SOAP simples
     */
    public function handle(Request $request)  // ← Ahora usa el Request correcto
    {
        $action = $request->get('action');
        $cuentaId = $request->get('cuenta_id');
        $monto = $request->get('monto');

        try {
            switch ($action) {
                case 'consultar_saldo':
                    $resultado = $this->consultarSaldo($cuentaId);
                    return $this->formatSoapResponse('Consulta de saldo exitosa', $resultado);

                case 'realizar_retiro':
                    if (!$monto) {
                        return $this->formatSoapResponse('Error: Monto requerido', null, false);
                    }
                    $resultado = $this->realizarRetiro($cuentaId, $monto);
                    return $this->formatSoapResponse('Retiro realizado exitosamente', $resultado);

                case 'info_cuenta':
                    $resultado = $this->consultarSaldo($cuentaId);
                    return $this->formatSoapResponse('Información de cuenta', $resultado);

                default:
                    return $this->formatSoapResponse('Error: Acción no válida. Use: consultar_saldo, realizar_retiro, info_cuenta', null, false);
            }
        } catch (\Exception $e) {
            return $this->formatSoapResponse('Error: ' . $e->getMessage(), null, false);
        }
    }

    /**
     * Consultar saldo de cuenta
     */
    private function consultarSaldo($cuentaId)
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

    /**
     * Realizar retiro usando procedimiento almacenado
     */
    private function realizarRetiro($cuentaId, $monto)
    {
        $cuenta = Cuenta::find($cuentaId);
        if (!$cuenta) {
            throw new \Exception('Cuenta no encontrada');
        }

        if ($cuenta->saldo < $monto) {
            throw new \Exception('Fondos insuficientes');
        }

        // Ejecutar procedimiento almacenado
        DB::statement('CALL RealizarRetiro(?, ?, @nuevo_saldo)', [$cuentaId, $monto]);
        
        $result = DB::select('SELECT @nuevo_saldo as nuevo_saldo');
        $nuevoSaldo = $result[0]->nuevo_saldo;

        return [
            'cuenta_id' => $cuentaId,
            'monto_retirado' => $monto,
            'nuevo_saldo' => $nuevoSaldo,
            'fecha' => now()->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Formatear respuesta SOAP
     */
    private function formatSoapResponse($message, $data = null, $success = true)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'data' => $data
        ], $success ? 200 : 400);
    }
}