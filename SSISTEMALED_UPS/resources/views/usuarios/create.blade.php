@extends('layouts.app')

@section('title', 'Nuevo Usuario')
@section('titulo', 'Nuevo Usuario')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/usuarios">Usuarios</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
<form action="/usuarios" method="POST">
    @csrf
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Datos del Usuario</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}"
                               class="form-control @error('nombre') is-invalid @enderror" required>
                        @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo electrónico <span class="text-danger">*</span></label>
                        <input type="email" name="correo" value="{{ old('correo') }}"
                               class="form-control @error('correo') is-invalid @enderror" required>
                        @error('correo')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contraseña <span class="text-danger">*</span></label>
                        <input type="password" name="contraseña"
                               class="form-control @error('contraseña') is-invalid @enderror" required minlength="6">
                        @error('contraseña')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirmar Contraseña <span class="text-danger">*</span></label>
                        <input type="password" name="contraseña_confirmation" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Rol <span class="text-danger">*</span></label>
                        <select name="rol_id" class="form-control @error('rol_id') is-invalid @enderror" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id_rol }}" {{ old('rol_id') == $rol->id_rol ? 'selected' : '' }}>
                                    {{ $rol->nombre_rol }}
                                </option>
                            @endforeach
                        </select>
                        @error('rol_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Región</label>
                        <select name="region_id" class="form-control">
                            <option value="">— Sin región —</option>
                            @foreach($regiones as $r)
                                <option value="{{ $r->id_region }}" {{ old('region_id') == $r->id_region ? 'selected' : '' }}>
                                    {{ $r->nombre_region }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Municipio</label>
                        <select name="municipio_id" class="form-control">
                            <option value="">— Sin municipio —</option>
                            @foreach($municipios as $m)
                                <option value="{{ $m->id_municipio }}" {{ old('municipio_id') == $m->id_municipio ? 'selected' : '' }}>
                                    {{ $m->nombre_municipio }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger"><i class="fas fa-save mr-1"></i> Guardar</button>
            <a href="/usuarios" class="btn btn-secondary ml-2"><i class="fas fa-times mr-1"></i> Cancelar</a>
        </div>
    </div>
</form>
@endsection
