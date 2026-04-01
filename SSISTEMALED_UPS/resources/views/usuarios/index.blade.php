@extends('layouts.app')

@section('title', 'Usuarios')
@section('titulo', 'Usuarios del Sistema')
@section('breadcrumb')
    <li class="breadcrumb-item active">Usuarios</li>
@endsection

@section('content')
<div class="card card-outline card-danger">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users-cog mr-1"></i> Usuarios</h3>
        <div class="card-tools d-flex">
            <form method="GET" action="/usuarios" class="mr-2">
                <div class="input-group input-group-sm">
                    <input type="text" name="busqueda" value="{{ request('busqueda') }}" class="form-control" placeholder="Buscar...">
                    <select name="rol_id" class="form-control ml-1" style="width:130px">
                        <option value="">Todos los roles</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id_rol }}" {{ request('rol_id') == $rol->id_rol ? 'selected' : '' }}>
                                {{ $rol->nombre_rol }}
                            </option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                        <a href="/usuarios" class="btn btn-default"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
            <a href="/usuarios/create" class="btn btn-danger btn-sm"><i class="fas fa-plus"></i> Nuevo</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Región</th>
                    <th>Municipio</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $u)
                    <tr>
                        <td>{{ $u->id_usuario }}</td>
                        <td>
                            <strong>{{ $u->nombre }}</strong>
                            @if($u->id_usuario == session('usuario_id'))
                                <span class="badge badge-info ml-1">Tú</span>
                            @endif
                        </td>
                        <td>{{ $u->correo }}</td>
                        <td>
                            <span class="badge badge-secondary">{{ $u->rol->nombre_rol ?? '—' }}</span>
                        </td>
                        <td>{{ $u->region->nombre_region ?? '—' }}</td>
                        <td>{{ $u->municipio->nombre_municipio ?? '—' }}</td>
                        <td class="text-right">
                            <a href="/usuarios/{{ $u->id_usuario }}/edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            @if($u->id_usuario != session('usuario_id'))
                                <form action="/usuarios/{{ $u->id_usuario }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este usuario?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Sin usuarios.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $usuarios->links() }}</div>
</div>
@endsection
