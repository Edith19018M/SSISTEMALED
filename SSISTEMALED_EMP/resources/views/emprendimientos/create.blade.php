@extends('layouts.app')

@section('title', 'Nuevo Emprendimiento')
@section('titulo', 'Nuevo Emprendimiento')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/emprendimientos">Emprendimientos</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
<form action="/emprendimientos" method="POST">
    @csrf

    {{-- Datos del emprendimiento --}}
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-rocket mr-1"></i> Datos del Emprendimiento</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}"
                               class="form-control @error('nombre') is-invalid @enderror"
                               placeholder="Nombre del emprendimiento" required>
                        @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Categoría <span class="text-danger">*</span></label>
                        <select name="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id_categoria }}" {{ old('categoria_id') == $cat->id_categoria ? 'selected' : '' }}>
                                    {{ $cat->nombre_categoria }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Municipio <span class="text-danger">*</span></label>
                        <select name="municipio_id" class="form-control @error('municipio_id') is-invalid @enderror" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($municipios as $m)
                                <option value="{{ $m->id_municipio }}" {{ old('municipio_id') == $m->id_municipio ? 'selected' : '' }}>
                                    {{ $m->nombre_municipio }} ({{ $m->region->nombre_region ?? '' }})
                                </option>
                            @endforeach
                        </select>
                        @error('municipio_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Estado del Proceso</label>
                        <select name="estado_proceso" class="form-control">
                            <option value="pendiente" {{ old('estado_proceso') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="activo"    {{ old('estado_proceso') == 'activo'    ? 'selected' : '' }}>Activo</option>
                            <option value="finalizado"{{ old('estado_proceso') == 'finalizado'? 'selected' : '' }}>Finalizado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sector / Rubro</label>
                        <input type="text" name="sector_rubro" value="{{ old('sector_rubro') }}"
                               class="form-control" placeholder="Ej. Alimentación, Textil">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Primer emprendedor (obligatorio) --}}
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-plus mr-1"></i> Primer Emprendedor
                <small class="text-muted ml-2">— requerido para crear el emprendimiento</small>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Código <span class="text-danger">*</span></label>
                        <input type="text" name="emp_codigo" value="{{ old('emp_codigo') }}"
                               class="form-control @error('emp_codigo') is-invalid @enderror"
                               placeholder="Ej. EMP-001" required>
                        @error('emp_codigo')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="emp_nombre" value="{{ old('emp_nombre') }}"
                               class="form-control @error('emp_nombre') is-invalid @enderror" required>
                        @error('emp_nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellidos <span class="text-danger">*</span></label>
                        <input type="text" name="emp_apellidos" value="{{ old('emp_apellidos') }}"
                               class="form-control @error('emp_apellidos') is-invalid @enderror" required>
                        @error('emp_apellidos')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label>Edad</label>
                        <input type="number" name="emp_edad" value="{{ old('emp_edad') }}"
                               class="form-control" min="1" max="120">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Sexo</label>
                        <select name="emp_sexo" class="form-control">
                            <option value="">—</option>
                            <option value="M" {{ old('emp_sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('emp_sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('emp_sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>CI</label>
                        <input type="text" name="emp_ci" value="{{ old('emp_ci') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Celular</label>
                        <input type="text" name="emp_celular" value="{{ old('emp_celular') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="emp_correo" value="{{ old('emp_correo') }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Carrera</label>
                        <input type="text" name="emp_carrera" value="{{ old('emp_carrera') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Año Estudio</label>
                        <input type="text" name="emp_año_estudio" value="{{ old('emp_año_estudio') }}"
                               class="form-control" placeholder="Ej. 3ro">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="emp_direccion" value="{{ old('emp_direccion') }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-info">
                <i class="fas fa-save mr-1"></i> Guardar Emprendimiento y Emprendedor
            </button>
            <a href="/emprendimientos" class="btn btn-secondary ml-2">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </div>
</form>
@endsection
