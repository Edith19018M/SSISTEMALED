@extends('layouts.app')

@section('title', 'Regiones')
@section('titulo', 'Gestión de Regiones')
@section('breadcrumb')
    <li class="breadcrumb-item active">Regiones</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus mr-1"></i> Nueva Región</h3>
            </div>
            <div class="card-body">
                <form action="/regiones" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nombre de la Región <span class="text-danger">*</span></label>
                        <input type="text" name="nombre_region" value="{{ old('nombre_region') }}"
                               class="form-control @error('nombre_region') is-invalid @enderror"
                               placeholder="Ej. Altiplano, Valle..." required>
                        @error('nombre_region')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-map mr-1"></i> Regiones registradas</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre de la Región</th>
                            <th class="text-center">Municipios</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($regiones as $r)
                            <tr>
                                <td>{{ $r->id_region }}</td>
                                <td><strong>{{ $r->nombre_region }}</strong></td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $r->municipios_count }}</span>
                                </td>
                                <td class="text-right">
                                    <form action="/regiones/{{ $r->id_region }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar esta región?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Sin regiones.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
