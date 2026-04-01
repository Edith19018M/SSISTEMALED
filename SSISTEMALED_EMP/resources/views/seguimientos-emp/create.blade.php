@extends('layouts.app')

@section('title', 'Nuevo Seguimiento')
@section('titulo', 'Nuevo Seguimiento de Emprendimiento')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/seguimientos-emprendimiento">Seguimientos</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
<form action="/seguimientos-emprendimiento" method="POST">
    @csrf
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plus mr-1"></i> Datos del Seguimiento</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Emprendimiento <span class="text-danger">*</span></label>
                        <select name="id_emprendimiento" class="form-control @error('id_emprendimiento') is-invalid @enderror" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($emprendimientos as $e)
                                <option value="{{ $e->id_emprendimiento }}"
                                    {{ (old('id_emprendimiento') ?? request('emprendimiento_id')) == $e->id_emprendimiento ? 'selected' : '' }}>
                                    {{ $e->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_emprendimiento')<span class="invalid-feedback">{{ $message }}</span>@enderror
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
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Crear Seguimiento
            </button>
            <a href="/seguimientos-emprendimiento" class="btn btn-secondary ml-2">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </div>
</form>
@endsection
