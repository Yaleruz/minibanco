<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Cliente;
use App\Models\TipoCuenta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CuentaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class CuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $cuentas = Cuenta::paginate();

        return view('cuenta.index', compact('cuentas'))
            ->with('i', ($request->input('page', 1) - 1) * $cuentas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $cuenta = new Cuenta();
        $identificacion= Cliente::pluck('identificacion_cliente', 'id');
        $tiposCuenta = TipoCuenta::pluck('tipo', 'id');
        return view('cuenta.create', compact('cuenta','identificacion','tiposCuenta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CuentaRequest $request): RedirectResponse
    {
        Cuenta::create($request->validated());

        return Redirect::route('cuentas.index')
            ->with('success', 'Cuenta created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $cuenta = Cuenta::find($id);

        return view('cuenta.show', compact('cuenta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $cuenta = Cuenta::find($id);
        $identificacion= Cliente::pluck('identificacion_cliente', 'id'); 
        $tiposCuenta = TipoCuenta::pluck('tipo', 'id');
        return view('cuenta.edit', compact('cuenta','identificacion','tiposCuenta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CuentaRequest $request, Cuenta $cuenta): RedirectResponse
    {
        $cuenta->update($request->validated());

        return Redirect::route('cuentas.index')
            ->with('success', 'Cuenta updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Cuenta::find($id)->delete();

        return Redirect::route('cuentas.index')
            ->with('success', 'Cuenta deleted successfully');
    }



}
