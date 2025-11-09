@extends('layouts.app')

@section('template_title')
    Retiros
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Retiros') }}
                        </span>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-info m-4">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="card-body bg-white">
                    <form action="{{ route('retiros.retirar') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="cuenta_id" class="form-label">Cuenta</label>
                            <select name="cuenta_id" id="cuenta_id" class="form-control" required>
                                <option value="">-- Seleccione una cuenta --</option>
                                @foreach ($cuentas as $cuenta)
                                    <option value="{{ $cuenta->id }}">
                                        {{ $cuenta->cliente->identificacion_cliente }}
                                        — {{ $cuenta->tipoCuenta->tipo }}
                                        — Saldo: ${{ number_format($cuenta->saldo_cuenta, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="monto" class="form-label">Monto a retirar</label>
                            <input type="number" step="0.01" min="0.01" name="monto" id="monto"
                                   class="form-control" placeholder="Ej: 500.00" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Realizar Retiro</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
