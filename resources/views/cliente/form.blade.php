<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="identificacion_cliente" class="form-label">{{ __('Identificacion Cliente') }}</label>
            <input type="text" name="identificacion_cliente" class="form-control @error('identificacion_cliente') is-invalid @enderror" value="{{ old('identificacion_cliente', $cliente?->identificacion_cliente) }}" id="identificacion_cliente" placeholder="Identificacion Cliente">
            {!! $errors->first('identificacion_cliente', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nombres" class="form-label">{{ __('Nombres') }}</label>
            <input type="text" name="Nombres" class="form-control @error('Nombres') is-invalid @enderror" value="{{ old('Nombres', $cliente?->Nombres) }}" id="nombres" placeholder="Nombres">
            {!! $errors->first('Nombres', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="apellidos" class="form-label">{{ __('Apellidos') }}</label>
            <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $cliente?->apellidos) }}" id="apellidos" placeholder="Apellidos">
            {!! $errors->first('apellidos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>