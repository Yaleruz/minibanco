<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    /**
     * GET /api/clientes
     */
    public function index()
    {
        $clientes = Cliente::all();
        
        return response()->json([
            'success' => true,
            'data' => $clientes,
            'count' => $clientes->count()
        ]);
    }

    /**
     * GET /api/clientes/{id}
     */
    public function show($id)
    {
        try {
            $cliente = $this->clienteService->getClienteConCuentas($id);
            
            return response()->json([
                'success' => true,
                'data' => $cliente
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * POST /api/clientes
     */
    public function store(Request $request)
    {
        $request->validate([
            'identificacion' => 'required|string|max:20',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100'
        ]);

        try {
            $cliente = $this->clienteService->crearCliente($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Cliente creado exitosamente',
                'data' => $cliente
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}