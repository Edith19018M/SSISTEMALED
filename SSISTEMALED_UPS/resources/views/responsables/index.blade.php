@extends('layouts.app')

@section('title', 'Responsables')
@section('titulo', 'Responsables')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/unidades">Unidades</a></li>
    <li class="breadcrumb-item active">Responsables</li>
@endsection

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-hard-hat mr-1"></i> Lista de Responsables</h3>
        <div class="card-tools d-flex">
            <form method="GET" action="/responsables" class="mr-2">
                <div class="input-group input-group-sm">
                    <input type="text" name="busqueda" value="{{ request('busqueda') }}" class="form-control" placeholder="Buscar...">
                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                        <a href="/responsables" class="btn btn-default"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
            <a href="/responsables/create" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i> Nuevo</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>CI</th>
                    <th>Contacto</th>
                    <th>Correo</th>
                    <th class="text-center">Unidades</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($responsables as $r)
                    <tr>
                        <td>{{ $r->id_responsable }}</td>
                        <td><strong>{{ $r->nombre }}</strong></td>
                        <td>{{ $r->ci ?? '—' }}</td>
                        <td>{{ $r->contacto ?? '—' }}</td>
                        <td>{{ $r->correo ?? '—' }}</td>
                        <td class="text-center"><span class="badge badge-success">{{ $r->unidadesProductivas->count() }}</span></td>
                        <td class="text-right">
                            <a href="/responsables/{{ $r->id_responsable }}/edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            <form action="/responsables/{{ $r->id_responsable }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Sin responsables.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $responsables->links() }}</div>
</div>
@endsection
