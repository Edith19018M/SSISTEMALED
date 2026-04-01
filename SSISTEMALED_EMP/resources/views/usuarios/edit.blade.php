@extends('layouts.app')

@section('title', 'Editar Usuario')
@section('titulo', 'Editar Usuario')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/usuarios">Usuarios</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<form action="/usuarios/{{ $usuario->id_usuario }}" method="POST">
    @csrf @method('PUT')
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-edit mr-1"></i> Editar: {{ $usuario->nombre }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo <span class="text-danger">*</span></label>
                        <input type="email" name="correo" value="{{ old('correo', $usuario->correo) }}" class="form-control" required>
                        @error('correo')<span class="text-danger small">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nueva Contraseña <small class="text-muted">(dejar en blanco para mantener)</small></label>
                        <input type="password" name="contraseña" class="form-control" minlength="6">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirmar Nueva Contraseña</label>
                        <input type="password" name="contraseña_confirmation" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Rol <span class="text-danger">*</span></label>
                        <select name="rol_id" class="form-control" required>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id_rol }}" {{ old('rol_id', $usuario->rol_id) == $rol->id_rol ? 'selected' : '' }}>
                                    {{ $rol->nombre_rol }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Región</label>
                        <select name="region_id" class="form-control">
                            <option value="">— Sin región —</option>
                            @foreach($regiones as $r)
                                <option value="{{ $r->id_region }}" {{ old('region_id', $usuario->region_id) == $r->id_region ? 'selected' : '' }}>
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
                                <option value="{{ $m->id_municipio }}" {{ old('municipio_id', $usuario->municipio_id) == $m->id_municipio ? 'selected' : '' }}>
                                    {{ $m->nombre_municipio }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- Emprendedor vinculado (solo visible cuando el rol es Emprendedor) --}}
            <div class="row" id="seccion-emprendedor" style="display:none;">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Emprendedor Vinculado</label>
                        <select name="emprendedor_id" class="form-control">
                            <option value="">— Sin vincular —</option>
                            @foreach($emprendedores as $emp)
                                <option value="{{ $emp->id_emprendedor }}"
                                    {{ old('emprendedor_id', $usuario->emprendedor_id) == $emp->id_emprendedor ? 'selected' : '' }}>
                                    {{ $emp->nombre }} {{ $emp->apellidos }} ({{ $emp->codigo ?? 'Sin código' }})
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Selecciona el emprendedor al que tendrá acceso este usuario.</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Actualizar</button>
            <a href="/usuarios" class="btn btn-secondary ml-2"><i class="fas fa-times mr-1"></i> Cancelar</a>
        </div>
    </div>
</form>

@push('scripts')
<script>
(function () {
    const rolSelect = document.querySelector('select[name="rol_id"]');
    const seccion = document.getElementById('seccion-emprendedor');

    function toggleEmprendedor() {
        const selected = rolSelect.options[rolSelect.selectedIndex];
        seccion.style.display = selected.text === 'Emprendedor' ? 'flex' : 'none';
    }

    rolSelect.addEventListener('change', toggleEmprendedor);
    toggleEmprendedor();
})();
</script>
@endpush

@endsection
