@extends('layouts.app')

@section('title', 'Nuevo Seguimiento Unidad')
@section('titulo', 'Nuevo Seguimiento de Unidad Productiva')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/seguimientos-unidad">Seguimientos</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
<form action="/seguimientos-unidad" method="POST">
    @csrf
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plus mr-1"></i> Datos del Seguimiento</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Unidad Productiva <span class="text-danger">*</span></label>
                        <select name="id_unidad" class="form-control @error('id_unidad') is-invalid @enderror" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($unidades as $u)
                                <option value="{{ $u->id_unidad }}"
                                    {{ (old('id_unidad') ?? request('unidad_id')) == $u->id_unidad ? 'selected' : '' }}>
                                    {{ $u->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_unidad')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>N° de Seguimiento <span class="text-danger">*</span></label>
                        <input type="number" name="numero_seguimiento" value="{{ old('numero_seguimiento', 1) }}"
                               class="form-control @error('numero_seguimiento') is-invalid @enderror" min="1" required>
                        @error('numero_seguimiento')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fecha <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="fecha" value="{{ old('fecha', now()->format('Y-m-d\TH:i')) }}"
                               class="form-control @error('fecha') is-invalid @enderror" required>
                        @error('fecha')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Crear</button>
            <a href="/seguimientos-unidad" class="btn btn-secondary ml-2"><i class="fas fa-times mr-1"></i> Cancelar</a>
        </div>
    </div>
</form>
@endsection
