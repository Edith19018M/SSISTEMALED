@extends('layouts.app')

@section('title', 'Municipios')
@section('titulo', 'Gestión de Municipios')
@section('breadcrumb')
    <li class="breadcrumb-item active">Municipios</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus mr-1"></i> Nuevo Municipio</h3>
            </div>
            <div class="card-body">
                <form action="/municipios" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nombre del Municipio <span class="text-danger">*</span></label>
                        <input type="text" name="nombre_municipio" value="{{ old('nombre_municipio') }}"
                               class="form-control @error('nombre_municipio') is-invalid @enderror" required>
                        @error('nombre_municipio')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Región <span class="text-danger">*</span></label>
                        <select name="id_region" class="form-control @error('id_region') is-invalid @enderror" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($regiones as $r)
                                <option value="{{ $r->id_region }}" {{ old('id_region') == $r->id_region ? 'selected' : '' }}>
                                    {{ $r->nombre_region }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_region')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-map-marker-alt mr-1"></i> Municipios</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Municipio</th>
                            <th>Región</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($municipios as $m)
                            <tr>
                                <td>{{ $m->id_municipio }}</td>
                                <td>{{ $m->nombre_municipio }}</td>
                                <td><span class="badge badge-info">{{ $m->region->nombre_region ?? '—' }}</span></td>
                                <td class="text-right">
                                    <form action="/municipios/{{ $m->id_municipio }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar este municipio?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Sin municipios.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $municipios->links() }}</div>
        </div>
    </div>
</div>
@endsection
