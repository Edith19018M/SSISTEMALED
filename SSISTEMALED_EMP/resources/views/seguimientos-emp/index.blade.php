@extends('layouts.app')

@section('title', 'Seguimientos de Emprendimientos')
@section('titulo', 'Seguimientos de Emprendimientos')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/emprendimientos">Emprendimientos</a></li>
    <li class="breadcrumb-item active">Seguimientos</li>
@endsection

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-clipboard-check mr-1"></i> Seguimientos</h3>
        <div class="card-tools d-flex">
            <form method="GET" action="/seguimientos-emprendimiento" class="mr-2">
                <div class="input-group input-group-sm">
                    <select name="emprendimiento_id" class="form-control">
                        <option value="">Todos los emprendimientos</option>
                        @foreach($emprendimientos as $e)
                            <option value="{{ $e->id_emprendimiento }}" {{ request('emprendimiento_id') == $e->id_emprendimiento ? 'selected' : '' }}>
                                {{ $e->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit"><i class="fas fa-filter"></i></button>
                        <a href="/seguimientos-emprendimiento" class="btn btn-default"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
            <a href="/seguimientos-emprendimiento/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>N° Seguimiento</th>
                    <th>Emprendimiento</th>
                    <th>Fecha</th>
                    <th class="text-center">Compromisos</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($seguimientos as $seg)
                    <tr>
                        <td><span class="badge badge-primary badge-lg">N° {{ $seg->numero_seguimiento }}</span></td>
                        <td>
                            <a href="/emprendimientos/{{ $seg->id_emprendimiento }}">
                                {{ $seg->emprendimiento->nombre ?? '—' }}
                            </a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($seg->fecha)->format('d/m/Y H:i') }}</td>
                        <td class="text-center"><span class="badge badge-secondary">{{ $seg->compromisos->count() }}</span></td>
                        <td class="text-right">
                            <a href="/seguimientos-emprendimiento/{{ $seg->id_seguimiento }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <form action="/seguimientos-emprendimiento/{{ $seg->id_seguimiento }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este seguimiento y todos sus datos?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-clipboard fa-2x mb-2 d-block"></i>Sin seguimientos registrados.
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $seguimientos->links() }}</div>
</div>
@endsection
