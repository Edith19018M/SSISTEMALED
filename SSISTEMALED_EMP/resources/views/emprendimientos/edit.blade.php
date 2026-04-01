@extends('layouts.app')

@section('title', 'Editar Emprendimiento')
@section('titulo', 'Editar Emprendimiento')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/emprendimientos">Emprendimientos</a></li>
    <li class="breadcrumb-item"><a href="/emprendimientos/{{ $emprendimiento->id_emprendimiento }}">{{ $emprendimiento->nombre }}</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<form action="/emprendimientos/{{ $emprendimiento->id_emprendimiento }}" method="POST">
    @csrf @method('PUT')
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-edit mr-1"></i> Editar: {{ $emprendimiento->nombre }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre', $emprendimiento->nombre) }}"
                               class="form-control @error('nombre') is-invalid @enderror" required>
                        @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Categoría <span class="text-danger">*</span></label>
                        <select name="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id_categoria }}"
                                    {{ old('categoria_id', $emprendimiento->categoria_id) == $cat->id_categoria ? 'selected' : '' }}>
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
                                <option value="{{ $m->id_municipio }}"
                                    {{ old('municipio_id', $emprendimiento->municipio_id) == $m->id_municipio ? 'selected' : '' }}>
                                    {{ $m->nombre_municipio }} ({{ $m->region->nombre_region ?? '' }})
                                </option>
                            @endforeach
                        </select>
                        @error('municipio_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Estado del Proceso</label>
                        <select name="estado_proceso" class="form-control">
                            @foreach(['pendiente','activo','finalizado'] as $estado)
                                <option value="{{ $estado }}"
                                    {{ old('estado_proceso', $emprendimiento->estado_proceso) == $estado ? 'selected' : '' }}>
                                    {{ ucfirst($estado) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion', $emprendimiento->direccion) }}"
                               class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sector / Rubro</label>
                        <input type="text" name="sector_rubro" value="{{ old('sector_rubro', $emprendimiento->sector_rubro) }}"
                               class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save mr-1"></i> Actualizar
            </button>
            <a href="/emprendimientos/{{ $emprendimiento->id_emprendimiento }}" class="btn btn-secondary ml-2">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </div>
</form>
@endsection
