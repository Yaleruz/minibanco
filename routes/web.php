<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RetiroController;

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::resource('cuentas', App\Http\Controllers\CuentaController::class);
Route::resource('clientes', App\Http\Controllers\ClienteController::class);
Route::resource('tipo_cuentas', App\Http\Controllers\TipoCuentaController::class);
Route::resource('retiros', App\Http\Controllers\RetiroController::class);
Route::get('/retiros', [RetiroController::class, 'index'])->name('retiros.index');
Route::post('/retiros', [RetiroController::class, 'retirar'])->name('retiros.retirar');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::prefix('api')->group(function () {
    // Ruta de prueba
    Route::get('/test', function () {
        return response()->json([
            'success' => true,
            'message' => 'API del Minibanco funcionando! 🚀',
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    });

    // Listar cuentas
    Route::get('/cuentas', function () {
        $cuentas = App\Models\Cuenta::with('cliente', 'tipoCuenta')->get();
        return response()->json([
            'success' => true,
            'data' => $cuentas,
            'count' => $cuentas->count()
        ]);
    });

    // Servicio SOAP - SOLO GET
    Route::get('/soap', function () {
        $request = request();
        $soapController = new App\Http\Controllers\SoapController();
        return $soapController->handle($request);
    });

    // Ruta específica para consultar saldo
    Route::get('/soap/consultar/{cuenta_id}', function ($cuentaId) {
        $soapController = new App\Http\Controllers\SoapController();
        
        // Crear request manualmente
        $request = new Illuminate\Http\Request();
        $request->replace(['action' => 'consultar_saldo', 'cuenta_id' => $cuentaId]);
        
        return $soapController->handle($request);
    });

    // Ruta específica para retiros
    Route::get('/soap/retirar/{cuenta_id}/{monto}', function ($cuentaId, $monto) {
        $soapController = new App\Http\Controllers\SoapController();
        
        // Crear request manualmente
        $request = new Illuminate\Http\Request();
        $request->replace([
            'action' => 'realizar_retiro', 
            'cuenta_id' => $cuentaId,
            'monto' => $monto
        ]);
        
        return $soapController->handle($request);
    });
});

// Ruta de diagnóstico
Route::get('/api/debug-cuenta/{id}', function ($id) {
    $cuenta = App\Models\Cuenta::find($id);
    
    return response()->json([
        'cuenta' => $cuenta,
        'cliente' => $cuenta->cliente,
        'tipo_cuenta' => $cuenta->tipoCuenta,
        'cliente_id' => $cuenta->identificacion,
        'tipo_cuenta_id' => $cuenta->tipo_cuenta
    ]);
});

// Ruta alternativa para probar el servicio

Route::get('/api/soap-test-fixed', function () {
    $transaccionService = new App\Services\TransaccionService();
    return $transaccionService->consultarSaldo(1);
});