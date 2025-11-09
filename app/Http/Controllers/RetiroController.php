<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cuenta;

class RetiroController extends Controller
{
    /**
     * Mostrar el formulario para hacer un retiro
     */
    public function index()
    {
        $cuentas = Cuenta::with(['cliente', 'tipoCuenta'])->get();
        return view('retiro.index', compact('cuentas'));
    }

    /**
     * Ejecutar el retiro llamando al procedimiento almacenado
     */
    public function retirar(Request $request)
    {
        $request->validate([
            'cuenta_id' => 'required|exists:cuentas,id',
            'monto' => 'required|numeric|min:0.01',
        ]);

        $cuentaId = $request->input('cuenta_id');
        $monto = $request->input('monto');

        // Llamar al procedimiento almacenado
        DB::statement('CALL sp_retirar_saldo(?, ?, @p_mensaje)', [$cuentaId, $monto]);
        $resultado = DB::select('SELECT @p_mensaje AS mensaje')[0]->mensaje;

        return redirect()->route('retiros.index')->with('success', $resultado);
    }
}
