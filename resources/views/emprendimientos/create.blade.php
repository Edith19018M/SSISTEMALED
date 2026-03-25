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
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plus mr-1"></i> Datos del Emprendimiento</h3>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Estado del Proceso</label>
                        <select name="estado_proceso" class="form-control">
                            <option value="pendiente" {{ old('estado_proceso') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="activo" {{ old('estado_proceso') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="finalizado" {{ old('estado_proceso') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}"
                               class="form-control" placeholder="Dirección del emprendimiento">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sector / Rubro</label>
                        <input type="text" name="sector_rubro" value="{{ old('sector_rubro') }}"
                               class="form-control" placeholder="Ej. Alimentación, Textil, etc.">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-info">
                <i class="fas fa-save mr-1"></i> Guardar
            </button>
            <a href="/emprendimientos" class="btn btn-secondary ml-2">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </div>
</form>
@endsection
