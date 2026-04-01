@extends('layouts.app')

@section('title', 'Nueva Venta')
@section('titulo', 'Registrar Venta')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/ventas">Ventas</a></li>
    <li class="breadcrumb-item active">Nueva</li>
@endsection

@section('content')
<form action="/ventas" method="POST">
    @csrf
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-cash-register mr-1"></i> Datos de la Venta</h3>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha <span class="text-danger">*</span></label>
                        <input type="date" name="fecha" value="{{ old('fecha', today()->toDateString()) }}"
                               class="form-control @error('fecha') is-invalid @enderror" required>
                        @error('fecha')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Producto <span class="text-danger">*</span></label>
                        <input type="text" name="producto" value="{{ old('producto') }}"
                               class="form-control @error('producto') is-invalid @enderror" required>
                        @error('producto')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cantidad <span class="text-danger">*</span></label>
                        <input type="number" name="cantidad" value="{{ old('cantidad', 1) }}"
                               class="form-control @error('cantidad') is-invalid @enderror" min="1" required>
                        @error('cantidad')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Precio (Bs) <span class="text-danger">*</span></label>
                        <input type="number" name="precio" value="{{ old('precio') }}" step="0.01"
                               class="form-control @error('precio') is-invalid @enderror" min="0" required>
                        @error('precio')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Guardar</button>
            <a href="/ventas" class="btn btn-secondary ml-2"><i class="fas fa-times mr-1"></i> Cancelar</a>
        </div>
    </div>
</form>
@endsection
