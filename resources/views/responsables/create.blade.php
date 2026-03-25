@extends('layouts.app')

@section('title', 'Nuevo Responsable')
@section('titulo', 'Nuevo Responsable')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/responsables">Responsables</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
<form action="/responsables" method="POST">
    @csrf
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Datos del Responsable</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}"
                               class="form-control @error('nombre') is-invalid @enderror" required>
                        @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contacto</label>
                        <input type="text" name="contacto" value="{{ old('contacto') }}" class="form-control" placeholder="Teléfono o celular">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CI</label>
                        <input type="text" name="ci" value="{{ old('ci') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="email" name="correo" value="{{ old('correo') }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Guardar</button>
            <a href="/responsables" class="btn btn-secondary ml-2"><i class="fas fa-times mr-1"></i> Cancelar</a>
        </div>
    </div>
</form>
@endsection
