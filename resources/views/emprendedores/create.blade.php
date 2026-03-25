@extends('layouts.app')

@section('title', 'Nuevo Emprendedor')
@section('titulo', 'Nuevo Emprendedor')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/emprendedores">Emprendedores</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
<form action="/emprendedores" method="POST">
    @csrf
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Datos del Emprendedor</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}"
                               class="form-control @error('nombre') is-invalid @enderror" required>
                        @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellidos <span class="text-danger">*</span></label>
                        <input type="text" name="apellidos" value="{{ old('apellidos') }}"
                               class="form-control @error('apellidos') is-invalid @enderror" required>
                        @error('apellidos')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Edad</label>
                        <input type="number" name="edad" value="{{ old('edad') }}"
                               class="form-control" min="1" max="120">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Sexo</label>
                        <select name="sexo" class="form-control">
                            <option value="">—</option>
                            <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>CI</label>
                        <input type="text" name="ci" value="{{ old('ci') }}" class="form-control" placeholder="Cédula de identidad">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Celular</label>
                        <input type="text" name="celular" value="{{ old('celular') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="correo" value="{{ old('correo') }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Carrera</label>
                        <input type="text" name="carrera" value="{{ old('carrera') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Año de Estudio</label>
                        <input type="text" name="año_estudio" value="{{ old('año_estudio') }}" class="form-control" placeholder="Ej. 3ro">
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="text-muted"><i class="fas fa-link mr-1"></i> Asociar a Emprendimiento (opcional)</h5>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Emprendimiento</label>
                        <select name="emprendimiento_id" class="form-control">
                            <option value="">— Sin asociar —</option>
                            @foreach($emprendimientos as $emp)
                                <option value="{{ $emp->id_emprendimiento }}" {{ old('emprendimiento_id') == $emp->id_emprendimiento ? 'selected' : '' }}>
                                    {{ $emp->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" id="es_responsable" name="es_responsable_principal" value="1">
                            <label class="custom-control-label" for="es_responsable">Es responsable principal</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save mr-1"></i> Guardar
            </button>
            <a href="/emprendedores" class="btn btn-secondary ml-2">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </div>
</form>
@endsection
