<div class="row padding-1 p-1">
    <div class="col-md-12">
        


       <div class="form-group mb-2 mb20">
    <label for="identificacion" class="form-label">{{ __('Identificación del Cliente') }}</label>
    <select name="identificacion" id="identificacion" 
            class="form-control @error('identificacion') is-invalid @enderror">
        <option value="">-- Seleccione un cliente --</option>
        @foreach($identificacion as $id => $identificacion_cliente)
            <option value="{{ $id }}" 
                {{ old('identificacion', $cuenta?->identificacion) == $id ? 'selected' : '' }}>
                {{ $identificacion_cliente }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('identificacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

<div class="form-group mb-2 mb20">
    <label for="tipo_cuenta" class="form-label">{{ __('Tipo de Cuenta') }}</label>
    <select name="tipo_cuenta" id="tipo_cuenta" 
            class="form-control @error('tipo_cuenta') is-invalid @enderror">
        <option value="">-- Seleccione un tipo de cuenta --</option>
        @foreach($tiposCuenta as $id => $nombre_tipo)
            <option value="{{ $id }}" 
                {{ old('tipo_cuenta', $cuenta?->tipo_cuenta) == $id ? 'selected' : '' }}>
                {{ $nombre_tipo }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('tipo_cuenta', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

        


        <div class="form-group mb-2 mb20">
            <label for="saldo_cuenta" class="form-label">{{ __('Saldo Cuenta') }}</label>
            <input type="text" name="saldo_cuenta" class="form-control @error('saldo_cuenta') is-invalid @enderror" value="{{ old('saldo_cuenta', $cuenta?->saldo_cuenta) }}" id="saldo_cuenta" placeholder="Saldo Cuenta">
            {!! $errors->first('saldo_cuenta', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>