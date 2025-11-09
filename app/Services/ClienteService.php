<?php

namespace App\Services;

use App\Models\Cliente;

class ClienteService
{
    /**
     * Obtener cliente con sus cuentas
     */
    public function getClienteConCuentas($clienteId)
    {
        $cliente = Cliente::with('cuentas.tipoCuenta')->find($clienteId);
        
        if (!$cliente) {
            throw new \Exception('Cliente no encontrado');
        }

        return $cliente;
    }

    /**
     * Crear nuevo cliente con validación
     */
    public function crearCliente($data)
    {
        // Validar que no exista cliente con misma identificación
        $existente = Cliente::where('identificacion', $data['identificacion'])->first();
        if ($existente) {
            throw new \Exception('Ya existe un cliente con esta identificación');
        }

        return Cliente::create($data);
    }
}