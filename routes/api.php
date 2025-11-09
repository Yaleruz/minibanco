<?php

use App\Http\Controllers\API\ClienteController;
use App\Http\Controllers\API\CuentaController;
use App\Http\Controllers\SoapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API REST para Clientes
Route::apiResource('clientes', ClienteController::class);
Route::get('clientes/{id}/cuentas', [ClienteController::class, 'show']);

// API REST para Cuentas  
Route::apiResource('cuentas', CuentaController::class);
Route::post('cuentas/{id}/retirar', [CuentaController::class, 'retirar']);

// Servicio SOAP simple
Route::post('/soap', [SoapController::class, 'handle']);

// Ruta de prueba
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API del Minibanco funcionando!',
        'timestamp' => now()->format('Y-m-d H:i:s')
    ]);
});