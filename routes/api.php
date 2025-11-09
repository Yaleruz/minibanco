<?php

use App\Http\Controllers\SoapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Ruta de prueba
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API del Minibanco funcionando!',
        'timestamp' => now()->format('Y-m-d H:i:s')
    ]);
});

// Por ahora, comentamos las rutas que usan controladores que no existen
// Route::apiResource('clientes', ClienteController::class);
// Route::apiResource('cuentas', CuentaController::class);
// Route::post('cuentas/{id}/retirar', [CuentaController::class, 'retirar']);

// Servicio SOAP simple
Route::post('/soap', [SoapController::class, 'handle']);