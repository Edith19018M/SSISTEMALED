@extends('layouts.app')

@section('title', $emprendimiento->nombre)
@section('titulo', $emprendimiento->nombre)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/emprendimientos">Emprendimientos</a></li>
    <li class="breadcrumb-item active">{{ $emprendimiento->nombre }}</li>
@endsection

@section('content')
<div class="row">
    {{-- Info principal --}}
    <div class="col-md-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Información</h3>
                @if(session('usuario_rol') === 'Administrador')
                <div class="card-tools">
                    <a href="/emprendimientos/{{ $emprendimiento->id_emprendimiento }}/edit" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                @endif
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Categoría</dt>
                    <dd class="col-sm-7">{{ $emprendimiento->categoria->nombre_categoria ?? '—' }}</dd>

                    <dt class="col-sm-5">Municipio</dt>
                    <dd class="col-sm-7">{{ $emprendimiento->municipio->nombre_municipio ?? '—' }}</dd>

                    <dt class="col-sm-5">Estado</dt>
                    <dd class="col-sm-7">
                        @php $color = match($emprendimiento->estado_proceso) { 'activo' => 'success', 'finalizado' => 'secondary', default => 'warning' }; @endphp
                        <span class="badge badge-{{ $color }}">{{ ucfirst($emprendimiento->estado_proceso) }}</span>
                    </dd>

                    <dt class="col-sm-5">Sector/Rubro</dt>
                    <dd class="col-sm-7">{{ $emprendimiento->sector_rubro ?? '—' }}</dd>

                    <dt class="col-sm-5">Dirección</dt>
                    <dd class="col-sm-7">{{ $emprendimiento->direccion ?? '—' }}</dd>

                    <dt class="col-sm-5">Creado</dt>
                    <dd class="col-sm-7">{{ $emprendimiento->created_at->format('d/m/Y') }}</dd>
                </dl>
            </div>
        </div>

        {{-- Emprendedores --}}
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-users mr-1"></i> Emprendedores ({{ $emprendimiento->emprendedores->count() }})</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($emprendimiento->emprendedores as $emp)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $emp->nombre }} {{ $emp->apellidos }}</strong>
                                @if($emp->pivot->es_responsable_principal)
                                    <span class="badge badge-warning ml-1">Principal</span>
                                @endif
                                <br><small class="text-muted">CI: {{ $emp->ci ?? '—' }} | {{ $emp->celular ?? '—' }}</small>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center">Sin emprendedores asignados</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer">
                <a href="/emprendedores/create" class="btn btn-sm btn-warning">
                    <i class="fas fa-plus"></i> Nuevo Emprendedor
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        {{-- Seguimientos --}}
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-clipboard-check mr-1"></i> Seguimientos ({{ $emprendimiento->seguimientos->count() }})</h3>
                <div class="card-tools">
                    <a href="/seguimientos-emprendimiento/create?emprendimiento_id={{ $emprendimiento->id_emprendimiento }}"
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>N°</th>
                            <th>Fecha</th>
                            <th class="text-center">Compromisos</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emprendimiento->seguimientos as $seg)
                            <tr>
                                <td><span class="badge badge-primary">{{ $seg->numero_seguimiento }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($seg->fecha)->format('d/m/Y') }}</td>
                                <td class="text-center"><span class="badge badge-secondary">{{ $seg->compromisos->count() }}</span></td>
                                <td class="text-right">
                                    <a href="/seguimientos-emprendimiento/{{ $seg->id_seguimiento }}" class="btn btn-xs btn-outline-primary">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Sin seguimientos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Asesorías --}}
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-comments mr-1"></i> Asesorías ({{ $emprendimiento->asesorias->count() }})</h3>
                @if(in_array(session('usuario_rol'), ['Administrador', 'Coordinador']))
                <div class="card-tools">
                    <a href="/asesorias/create?emprendimiento_id={{ $emprendimiento->id_emprendimiento }}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-plus"></i> Nueva
                    </a>
                </div>
                @endif
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Temática</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emprendimiento->asesorias as $as)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($as->fecha)->format('d/m/Y') }}</td>
                                <td>{{ $as->tipo }}</td>
                                <td>{{ Str::limit($as->tematica, 40) }}</td>
                                <td class="text-right">
                                    <a href="/asesorias/{{ $as->id_asesoria }}" class="btn btn-xs btn-outline-secondary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Sin asesorías</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Productos --}}
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-box mr-1"></i> Productos ({{ $emprendimiento->productos->count() }})</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="thead-light">
                        <tr><th>Nombre</th><th>Precio</th></tr>
                    </thead>
                    <tbody>
                        @forelse($emprendimiento->productos as $prod)
                            <tr>
                                <td>{{ $prod->nombre ?? $prod->descripcion ?? '—' }}</td>
                                <td>{{ $prod->precio ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center text-muted">Sin productos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
