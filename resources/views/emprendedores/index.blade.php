@extends('layouts.app')

@section('title', 'Emprendedores')
@section('titulo', 'Emprendedores')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/emprendimientos">Emprendimientos</a></li>
    <li class="breadcrumb-item active">Emprendedores</li>
@endsection

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users mr-1"></i> Lista de Emprendedores</h3>
        <div class="card-tools d-flex">
            <form method="GET" action="/emprendedores" class="mr-2">
                <div class="input-group input-group-sm">
                    <input type="text" name="busqueda" value="{{ request('busqueda') }}"
                           class="form-control" placeholder="Buscar nombre, CI...">
                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                        <a href="/emprendedores" class="btn btn-default"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
            <a href="/emprendedores/create" class="btn btn-warning btn-sm">
                <i class="fas fa-plus"></i> Nuevo
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nombre Completo</th>
                    <th>CI</th>
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Carrera</th>
                    <th class="text-center">Emprendimientos</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emprendedores as $emp)
                    <tr>
                        <td>{{ $emp->id_emprendedor }}</td>
                        <td>
                            <strong>{{ $emp->nombre }} {{ $emp->apellidos }}</strong>
                            @if($emp->edad)
                                <br><small class="text-muted">{{ $emp->edad }} años — {{ $emp->sexo ?? '' }}</small>
                            @endif
                        </td>
                        <td>{{ $emp->ci ?? '—' }}</td>
                        <td>{{ $emp->celular ?? '—' }}</td>
                        <td>{{ $emp->correo ?? '—' }}</td>
                        <td>
                            {{ $emp->carrera ?? '—' }}
                            @if($emp->año_estudio)
                                <br><small class="text-muted">{{ $emp->año_estudio }}</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge badge-info">{{ $emp->emprendimientos->count() }}</span>
                        </td>
                        <td class="text-right">
                            <a href="/emprendedores/{{ $emp->id_emprendedor }}/edit" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/emprendedores/{{ $emp->id_emprendedor }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este emprendedor?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-users fa-2x mb-2 d-block"></i>
                            No se encontraron emprendedores.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $emprendedores->links() }}</div>
</div>
@endsection
