<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cuenta;
use App\Services\TransaccionService;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    protected $transaccionService;

    public function __construct(TransaccionService $transaccionService)
    {
        $this->transaccionService = $transaccionService;
    }

    /**
     * GET /api/cuentas
     * Listar todas las cuentas
     */
    public function index()
    {
        $cuentas = Cuenta::with('cliente', 'tipoCuenta')->get();
        
        return response()->json([
            'success' => true,
            'data' => $cuentas,
            'count' => $cuentas->count()
        ]);
    }

    /**
     * GET /api/cuentas/{id}
     * Mostrar cuenta específica
     */
    public function show($id)
    {
        try {
            $cuentaInfo = $this->transaccionService->consultarSaldo($id);
            
            return response()->json([
                'success' => true,
                'data' => $cuentaInfo
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * POST /api/cuentas/{id}/retirar
     * Realizar retiro
     */
    public function retirar(Request $request, $id)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01'
        ]);

        try {
            $resultado = $this->transaccionService->realizarRetiro($id, $request->monto);
            
            return response()->json([
                'success' => true,
                'message' => 'Retiro realizado exitosamente',
                'data' => $resultado
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}