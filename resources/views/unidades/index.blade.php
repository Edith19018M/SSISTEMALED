@extends('layouts.app')

@section('title', 'Unidades Productivas')
@section('titulo', 'Unidades Productivas')
@section('breadcrumb')
    <li class="breadcrumb-item active">Unidades Productivas</li>
@endsection

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-industry mr-1"></i> Lista de Unidades Productivas</h3>
        <div class="card-tools d-flex">
            <form method="GET" action="/unidades" class="mr-2">
                <div class="input-group input-group-sm">
                    <input type="text" name="busqueda" value="{{ request('busqueda') }}"
                           class="form-control" placeholder="Buscar...">
                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                        <a href="/unidades" class="btn btn-default"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
            @if(session('usuario_rol') === 'Administrador')
            <a href="/unidades/create" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Nueva
            </a>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Municipio</th>
                    <th>Dirección</th>
                    <th class="text-center">Responsables</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($unidades as $u)
                    <tr>
                        <td>{{ $u->id_unidad }}</td>
                        <td>
                            <a href="/unidades/{{ $u->id_unidad }}" class="font-weight-bold">
                                {{ $u->nombre }}
                            </a>
                        </td>
                        <td>{{ $u->categoria->nombre_categoria ?? '—' }}</td>
                        <td>{{ $u->municipio->nombre_municipio ?? '—' }}</td>
                        <td>{{ $u->direccion ?? '—' }}</td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ $u->responsables->count() }}</span>
                        </td>
                        <td class="text-right">
                            <a href="/unidades/{{ $u->id_unidad }}" class="btn btn-sm btn-outline-success"><i class="fas fa-eye"></i></a>
                            @if(session('usuario_rol') === 'Administrador')
                            <a href="/unidades/{{ $u->id_unidad }}/edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            <form action="/unidades/{{ $u->id_unidad }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta unidad productiva?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-industry fa-2x mb-2 d-block"></i>Sin unidades productivas.
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $unidades->links() }}</div>
</div>
@endsection
