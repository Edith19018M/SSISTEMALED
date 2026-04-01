@extends('layouts.app')

@section('title', $unidad->nombre)
@section('titulo', $unidad->nombre)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/unidades">Unidades</a></li>
    <li class="breadcrumb-item active">{{ $unidad->nombre }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        {{-- Info --}}
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Información</h3>
                @if(session('usuario_rol') === 'Administrador')
                <div class="card-tools">
                    <a href="/unidades/{{ $unidad->id_unidad }}/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                </div>
                @endif
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Categoría</dt>
                    <dd class="col-sm-7">{{ $unidad->categoria->nombre_categoria ?? '—' }}</dd>
                    <dt class="col-sm-5">Municipio</dt>
                    <dd class="col-sm-7">{{ $unidad->municipio->nombre_municipio ?? '—' }}</dd>
                    <dt class="col-sm-5">Dirección</dt>
                    <dd class="col-sm-7">{{ $unidad->direccion ?? '—' }}</dd>
                    <dt class="col-sm-5">Creado</dt>
                    <dd class="col-sm-7">{{ $unidad->created_at->format('d/m/Y') }}</dd>
                </dl>
            </div>
        </div>

        {{-- Responsables --}}
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-hard-hat mr-1"></i> Responsables</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($unidad->responsables as $resp)
                        <li class="list-group-item">
                            <strong>{{ $resp->nombre }}</strong>
                            <br><small class="text-muted">
                                Desde: {{ $resp->pivot->fecha_inicio }} — Hasta: {{ $resp->pivot->fecha_fin ?? 'Actual' }}
                            </small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center">Sin responsables</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-warning" data-toggle="collapse" data-target="#form-responsable">
                    <i class="fas fa-plus"></i> Asociar Responsable
                </button>
                <div class="collapse mt-2" id="form-responsable">
                    <form action="/unidades/{{ $unidad->id_unidad }}/responsable" method="POST">
                        @csrf
                        <div class="form-group">
                            <select name="id_responsable" class="form-control form-control-sm" required>
                                <option value="">— Seleccionar —</option>
                                @foreach($responsables as $r)
                                    <option value="{{ $r->id_responsable }}">{{ $r->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="date" name="fecha_inicio" class="form-control form-control-sm" placeholder="Fecha inicio" required>
                        </div>
                        <div class="form-group">
                            <input type="date" name="fecha_fin" class="form-control form-control-sm" placeholder="Fecha fin (opcional)">
                        </div>
                        <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        {{-- Seguimientos --}}
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks mr-1"></i> Seguimientos ({{ $unidad->seguimientos->count() }})</h3>
                <div class="card-tools">
                    <a href="/seguimientos-unidad/create?unidad_id={{ $unidad->id_unidad }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="thead-light">
                        <tr><th>N°</th><th>Fecha</th><th class="text-center">Compromisos</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse($unidad->seguimientos as $seg)
                            <tr>
                                <td><span class="badge badge-primary">{{ $seg->numero_seguimiento }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($seg->fecha)->format('d/m/Y') }}</td>
                                <td class="text-center"><span class="badge badge-secondary">{{ $seg->compromisos->count() }}</span></td>
                                <td><a href="/seguimientos-unidad/{{ $seg->id_seguimiento }}" class="btn btn-xs btn-outline-primary"><i class="fas fa-eye"></i></a></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Sin seguimientos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Compras / Ventas --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-danger">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-shopping-cart mr-1"></i> Compras ({{ $unidad->compras->count() }})</h3>
                        <div class="card-tools">
                            <a href="/compras/create?unidad_id={{ $unidad->id_unidad }}" class="btn btn-xs btn-danger"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <tbody>
                                @forelse($unidad->compras->take(5) as $c)
                                    <tr>
                                        <td>{{ $c->producto }}</td>
                                        <td class="text-right">Bs {{ number_format($c->costo, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td class="text-center text-muted">Sin compras</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-cash-register mr-1"></i> Ventas ({{ $unidad->ventas->count() }})</h3>
                        <div class="card-tools">
                            <a href="/ventas/create?unidad_id={{ $unidad->id_unidad }}" class="btn btn-xs btn-success"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <tbody>
                                @forelse($unidad->ventas->take(5) as $v)
                                    <tr>
                                        <td>{{ $v->producto }}</td>
                                        <td class="text-right">Bs {{ number_format($v->precio, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td class="text-center text-muted">Sin ventas</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
