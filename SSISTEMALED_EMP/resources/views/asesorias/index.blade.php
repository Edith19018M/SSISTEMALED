@extends('layouts.app')

@section('title', 'Asesorías')
@section('titulo', 'Asesorías')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/emprendimientos">Emprendimientos</a></li>
    <li class="breadcrumb-item active">Asesorías</li>
@endsection

@section('content')
<div class="card card-outline card-secondary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-comments mr-1"></i> Lista de Asesorías</h3>
        <div class="card-tools d-flex">
            <form method="GET" action="/asesorias" class="mr-2">
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
                        <a href="/asesorias" class="btn btn-default"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
            <a href="/asesorias/create" class="btn btn-secondary btn-sm">
                <i class="fas fa-plus"></i> Nueva
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Emprendimiento</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Tipo</th>
                    <th>Temática</th>
                    <th class="text-center">Compromisos</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asesorias as $as)
                    <tr>
                        <td>{{ $as->emprendimiento->nombre ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($as->fecha)->format('d/m/Y') }}</td>
                        <td>
                            <small>{{ $as->hora_inicio }} – {{ $as->hora_fin }}</small>
                        </td>
                        <td><span class="badge badge-info">{{ $as->tipo }}</span></td>
                        <td>{{ Str::limit($as->tematica, 40) }}</td>
                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $as->compromisos->count() }}</span>
                        </td>
                        <td class="text-right">
                            <a href="/asesorias/{{ $as->id_asesoria }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/asesorias/{{ $as->id_asesoria }}/edit" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/asesorias/{{ $as->id_asesoria }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta asesoría?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Sin asesorías registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $asesorias->links() }}</div>
</div>
@endsection
