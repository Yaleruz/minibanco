<?php

namespace App\Http\Controllers;

use App\Services\TransaccionService;
use Illuminate\Http\Request;

class SoapController extends Controller
{
    protected $transaccionService;

    public function __construct(TransaccionService $transaccionService)
    {
        $this->transaccionService = $transaccionService;
    }

    /**
     * Manejar solicitudes SOAP simples
     */
    public function handle(Request $request)
    {
        $action = $request->get('action');
        $cuentaId = $request->get('cuenta_id');
        $monto = $request->get('monto');

        try {
            switch ($action) {
                case 'consultar_saldo':
                    //  USAR EL SERVICIO EN LUGAR DE LÓGICA DIRECTA
                    $resultado = $this->transaccionService->consultarSaldo($cuentaId);
                    return $this->formatSoapResponse('Consulta de saldo exitosa', $resultado);

                case 'realizar_retiro':
                    if (!$monto) {
                        return $this->formatSoapResponse('Error: Monto requerido', null, false);
                    }
                    // USAR EL SERVICIO EN LUGAR DE LÓGICA DIRECTA
                    $resultado = $this->transaccionService->realizarRetiro($cuentaId, $monto);
                    return $this->formatSoapResponse('Retiro realizado exitosamente', $resultado);

                case 'info_cuenta':
                    //  USAR EL SERVICIO EN LUGAR DE LÓGICA DIRECTA
                    $resultado = $this->transaccionService->consultarSaldo($cuentaId);
                    return $this->formatSoapResponse('Información de cuenta', $resultado);

                default:
                    return $this->formatSoapResponse('Error: Acción no válida. Use: consultar_saldo, realizar_retiro, info_cuenta', null, false);
            }
        } catch (\Exception $e) {
            return $this->formatSoapResponse('Error: ' . $e->getMessage(), null, false);
        }
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