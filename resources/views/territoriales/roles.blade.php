@extends('layouts.app')

@section('title', 'Roles')
@section('titulo', 'Gestión de Roles')
@section('breadcrumb')
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus mr-1"></i> Nuevo Rol</h3>
            </div>
            <div class="card-body">
                <form action="/roles" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nombre del Rol <span class="text-danger">*</span></label>
                        <input type="text" name="nombre_rol" value="{{ old('nombre_rol') }}"
                               class="form-control @error('nombre_rol') is-invalid @enderror"
                               placeholder="Ej. Coordinador, Técnico..." required>
                        @error('nombre_rol')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list mr-1"></i> Roles registrados</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre del Rol</th>
                            <th class="text-center">Usuarios</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $rol)
                            <tr>
                                <td>{{ $rol->id_rol }}</td>
                                <td><strong>{{ $rol->nombre_rol }}</strong></td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $rol->usuarios_count > 0 ? 'info' : 'secondary' }}">
                                        {{ $rol->usuarios_count }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <form action="/roles/{{ $rol->id_rol }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar este rol?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                {{ $rol->usuarios_count > 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Sin roles registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
