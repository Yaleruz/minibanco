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
     * Simulamos un servicio SOAP básico
     */
    public function handle(Request $request)
    {
        // Para SOAP normalmente usaríamos XML, pero haremos una versión simple
        $action = $request->get('action');
        $cuentaId = $request->get('cuenta_id');
        $monto = $request->get('monto');

        // Log de la solicitud (opcional)
        \Log::info('Solicitud SOAP recibida', [
            'action' => $action,
            'cuenta_id' => $cuentaId,
            'monto' => $monto
        ]);

        try {
            switch ($action) {
                case 'consultar_saldo':
                    $resultado = $this->transaccionService->consultarSaldo($cuentaId);
                    return $this->formatSoapResponse('Consulta de saldo exitosa', $resultado);

                case 'realizar_retiro':
                    if (!$monto) {
                        return $this->formatSoapResponse('Error: Monto requerido', null, false);
                    }
                    $resultado = $this->transaccionService->realizarRetiro($cuentaId, $monto);
                    return $this->formatSoapResponse('Retiro realizado exitosamente', $resultado);

                case 'info_cuenta':
                    $resultado = $this->transaccionService->consultarSaldo($cuentaId);
                    return $this->formatSoapResponse('Información de cuenta', $resultado);

                default:
                    return $this->formatSoapResponse('Error: Acción no válida. Acciones permitidas: consultar_saldo, realizar_retiro, info_cuenta', null, false);
            }
        } catch (\Exception $e) {
            return $this->formatSoapResponse('Error: ' . $e->getMessage(), null, false);
        }
    }

    /**
     * Formatear respuesta en estilo SOAP simple
     */
    private function formatSoapResponse($message, $data = null, $success = true)
    {
        $response = [
            'success' => $success,
            'message' => $message,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'data' => $data
        ];

        // En un SOAP real esto sería XML, pero usamos JSON para simplicidad
        return response()->json($response, $success ? 200 : 400);
    }
}