<?php

namespace App\Http\Controllers;

use App\Models\TipoCuenta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TipoCuentaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TipoCuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tipoCuentas = TipoCuenta::paginate();

        return view('tipo_cuenta.index', compact('tipoCuentas'))
            ->with('i', ($request->input('page', 1) - 1) * $tipoCuentas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tipoCuenta = new TipoCuenta();

        return view('tipo_cuenta.create', compact('tipoCuenta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TipoCuentaRequest $request): RedirectResponse
    {
        TipoCuenta::create($request->validated());

        return Redirect::route('tipo_cuentas.index')
            ->with('success', 'TipoCuenta created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $tipoCuenta = TipoCuenta::find($id);

        return view('tipo_cuentas.show', compact('tipoCuenta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tipoCuenta = TipoCuenta::find($id);

        return view('tipo_cuenta.edit', compact('tipoCuenta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TipoCuentaRequest $request, TipoCuenta $tipoCuenta): RedirectResponse
    {
        $tipoCuenta->update($request->validated());

        return Redirect::route('tipo_cuentas.index')
            ->with('success', 'TipoCuenta updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        TipoCuenta::find($id)->delete();

        return Redirect::route('tipo_cuentas.index')
            ->with('success', 'TipoCuenta deleted successfully');
    }
}
