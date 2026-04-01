@extends('layouts.emprendedor')

@section('title', 'Editar Perfil')
@section('titulo', 'Editar Datos Personales')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/mi-perfil">Mi Perfil</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Actualizar Datos Personales</h3>
            </div>
            <form action="/mi-perfil/editar" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre', $emprendedor->nombre) }}" required>
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Apellidos <span class="text-danger">*</span></label>
                            <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror"
                                   value="{{ old('apellidos', $emprendedor->apellidos) }}" required>
                            @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Edad</label>
                            <input type="number" name="edad" class="form-control @error('edad') is-invalid @enderror"
                                   value="{{ old('edad', $emprendedor->edad) }}" min="1" max="120">
                            @error('edad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>Sexo</label>
                            <select name="sexo" class="form-control @error('sexo') is-invalid @enderror">
                                <option value="">— Seleccionar —</option>
                                @foreach(['Masculino', 'Femenino', 'Otro'] as $opcion)
                                    <option value="{{ $opcion }}" {{ old('sexo', $emprendedor->sexo) === $opcion ? 'selected' : '' }}>
                                        {{ $opcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sexo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>C.I.</label>
                            <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror"
                                   value="{{ old('ci', $emprendedor->ci) }}">
                            @error('ci')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Celular</label>
                            <input type="text" name="celular" class="form-control @error('celular') is-invalid @enderror"
                                   value="{{ old('celular', $emprendedor->celular) }}">
                            @error('celular')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Correo</label>
                            <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror"
                                   value="{{ old('correo', $emprendedor->correo) }}">
                            @error('correo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Dirección</label>
                        <textarea name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                                  rows="2">{{ old('direccion', $emprendedor->direccion) }}</textarea>
                        @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Carrera</label>
                            <input type="text" name="carrera" class="form-control @error('carrera') is-invalid @enderror"
                                   value="{{ old('carrera', $emprendedor->carrera) }}">
                            @error('carrera')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Año de Estudio</label>
                            <input type="text" name="año_estudio" class="form-control @error('año_estudio') is-invalid @enderror"
                                   value="{{ old('año_estudio', $emprendedor->año_estudio) }}">
                            @error('año_estudio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i> Guardar Cambios
                    </button>
                    <a href="/mi-perfil" class="btn btn-secondary ml-2">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
