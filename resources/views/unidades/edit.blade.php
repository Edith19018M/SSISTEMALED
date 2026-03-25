@extends('layouts.app')

@section('title', 'Editar Unidad')
@section('titulo', 'Editar Unidad Productiva')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/unidades">Unidades</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<form action="/unidades/{{ $unidad->id_unidad }}" method="POST">
    @csrf @method('PUT')
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-edit mr-1"></i> Editar: {{ $unidad->nombre }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre', $unidad->nombre) }}"
                               class="form-control @error('nombre') is-invalid @enderror" required>
                        @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Categoría <span class="text-danger">*</span></label>
                        <select name="categoria_id" class="form-control" required>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id_categoria }}" {{ old('categoria_id', $unidad->categoria_id) == $cat->id_categoria ? 'selected' : '' }}>
                                    {{ $cat->nombre_categoria }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Municipio <span class="text-danger">*</span></label>
                        <select name="municipio_id" class="form-control" required>
                            @foreach($municipios as $m)
                                <option value="{{ $m->id_municipio }}" {{ old('municipio_id', $unidad->municipio_id) == $m->id_municipio ? 'selected' : '' }}>
                                    {{ $m->nombre_municipio }} ({{ $m->region->nombre_region ?? '' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion', $unidad->direccion) }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Actualizar</button>
            <a href="/unidades/{{ $unidad->id_unidad }}" class="btn btn-secondary ml-2"><i class="fas fa-times mr-1"></i> Cancelar</a>
        </div>
    </div>
</form>
@endsection
