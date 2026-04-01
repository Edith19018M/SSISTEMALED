@extends('layouts.app')

@section('title', 'Emprendimientos')
@section('titulo', 'Emprendimientos')
@section('breadcrumb')
    <li class="breadcrumb-item active">Emprendimientos</li>
@endsection

@section('content')
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-rocket mr-1"></i> Lista de Emprendimientos</h3>
        <div class="card-tools d-flex">
            <form method="GET" action="/emprendimientos" class="mr-2">
                <div class="input-group input-group-sm">
                    <input type="text" name="busqueda" value="{{ request('busqueda') }}"
                           class="form-control" placeholder="Buscar...">
                    <select name="estado" class="form-control ml-1" style="width:130px">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-default btn-sm" type="submit"><i class="fas fa-search"></i></button>
                        <a href="/emprendimientos" class="btn btn-default btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
            @if(session('usuario_rol') === 'Administrador')
            <a href="/emprendimientos/create" class="btn btn-info btn-sm">
                <i class="fas fa-plus"></i> Nuevo
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
                    <th>Sector/Rubro</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Emprendedores</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emprendimientos as $e)
                    <tr>
                        <td>{{ $e->id_emprendimiento }}</td>
                        <td>
                            <a href="/emprendimientos/{{ $e->id_emprendimiento }}" class="font-weight-bold">
                                {{ $e->nombre }}
                            </a>
                            @if($e->direccion)
                                <br><small class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $e->direccion }}</small>
                            @endif
                        </td>
                        <td>{{ $e->categoria->nombre_categoria ?? '—' }}</td>
                        <td>{{ $e->municipio->nombre_municipio ?? '—' }}</td>
                        <td>{{ $e->sector_rubro ?? '—' }}</td>
                        <td class="text-center">
                            @php
                                $color = match($e->estado_proceso) {
                                    'activo'     => 'success',
                                    'finalizado' => 'secondary',
                                    default      => 'warning',
                                };
                            @endphp
                            <span class="badge badge-{{ $color }}">{{ ucfirst($e->estado_proceso) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-info">{{ $e->emprendedores->count() }}</span>
                        </td>
                        <td class="text-right">
                            <a href="/emprendimientos/{{ $e->id_emprendimiento }}" class="btn btn-sm btn-outline-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(session('usuario_rol') === 'Administrador')
                            <a href="/emprendimientos/{{ $e->id_emprendimiento }}/edit" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/emprendimientos/{{ $e->id_emprendimiento }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este emprendimiento?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            No se encontraron emprendimientos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $emprendimientos->links() }}
    </div>
</div>
@endsection
