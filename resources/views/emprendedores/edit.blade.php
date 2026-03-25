@extends('layouts.app')

@section('title', 'Editar Emprendedor')
@section('titulo', 'Editar Emprendedor')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/emprendedores">Emprendedores</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<form action="/emprendedores/{{ $emprendedor->id_emprendedor }}" method="POST">
    @csrf @method('PUT')
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-edit mr-1"></i> Editar: {{ $emprendedor->nombre }} {{ $emprendedor->apellidos }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre', $emprendedor->nombre) }}"
                               class="form-control @error('nombre') is-invalid @enderror" required>
                        @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellidos <span class="text-danger">*</span></label>
                        <input type="text" name="apellidos" value="{{ old('apellidos', $emprendedor->apellidos) }}"
                               class="form-control @error('apellidos') is-invalid @enderror" required>
                        @error('apellidos')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Edad</label>
                        <input type="number" name="edad" value="{{ old('edad', $emprendedor->edad) }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Sexo</label>
                        <select name="sexo" class="form-control">
                            <option value="">—</option>
                            @foreach(['M' => 'Masculino', 'F' => 'Femenino', 'Otro' => 'Otro'] as $val => $label)
                                <option value="{{ $val }}" {{ old('sexo', $emprendedor->sexo) == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>CI</label>
                        <input type="text" name="ci" value="{{ old('ci', $emprendedor->ci) }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Celular</label>
                        <input type="text" name="celular" value="{{ old('celular', $emprendedor->celular) }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="email" name="correo" value="{{ old('correo', $emprendedor->correo) }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion', $emprendedor->direccion) }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Carrera</label>
                        <input type="text" name="carrera" value="{{ old('carrera', $emprendedor->carrera) }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Año Estudio</label>
                        <input type="text" name="año_estudio" value="{{ old('año_estudio', $emprendedor->año_estudio) }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save mr-1"></i> Actualizar
            </button>
            <a href="/emprendedores" class="btn btn-secondary ml-2">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </div>
</form>
@endsection
