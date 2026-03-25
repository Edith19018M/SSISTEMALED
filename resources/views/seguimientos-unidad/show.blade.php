@extends('layouts.app')

@section('title', 'Seguimiento N° ' . $seguimiento->numero_seguimiento)
@section('titulo', 'Seguimiento N° ' . $seguimiento->numero_seguimiento)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/seguimientos-unidad">Seguimientos</a></li>
    <li class="breadcrumb-item active">N° {{ $seguimiento->numero_seguimiento }}</li>
@endsection

@section('content')
<div class="callout callout-success mb-3">
    <h5><i class="fas fa-industry mr-1"></i> {{ $seguimiento->unidad->nombre ?? '—' }}</h5>
    <p class="mb-0">
        <strong>Seguimiento N°:</strong> {{ $seguimiento->numero_seguimiento }} &nbsp;|&nbsp;
        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($seguimiento->fecha)->format('d/m/Y H:i') }}
    </p>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-danger">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-handshake mr-1"></i> Compromisos ({{ $seguimiento->compromisos->count() }})</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        @forelse($seguimiento->compromisos as $comp)
                            <tr>
                                <td>
                                    <span class="badge badge-{{ $comp->estado === 'cumplido' ? 'success' : 'warning' }} mr-2">
                                        {{ ucfirst($comp->estado) }}
                                    </span>
                                    {{ $comp->descripcion }}
                                </td>
                                <td class="text-right">
                                    <form action="/compromisos-unidad/{{ $comp->id_compromiso }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-outline-danger"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="text-center text-muted py-3">Sin compromisos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <form action="/seguimientos-unidad/{{ $seguimiento->id_seguimiento }}/compromisos" method="POST">
                    @csrf
                    <textarea name="descripcion" class="form-control form-control-sm mb-2" rows="2" placeholder="Descripción..." required></textarea>
                    <div class="d-flex">
                        <select name="estado" class="form-control form-control-sm mr-2">
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En proceso</option>
                            <option value="cumplido">Cumplido</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-plus"></i> Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-check-circle mr-1"></i> Actividades ({{ $seguimiento->actividades->count() }})</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        @forelse($seguimiento->actividades as $act)
                            <tr>
                                <td>
                                    <span class="badge badge-{{ $act->estado === 'completada' ? 'success' : 'warning' }} mr-2">
                                        {{ ucfirst($act->estado) }}
                                    </span>
                                    {{ $act->descripcion }}
                                </td>
                                <td class="text-right">
                                    <form action="/actividades-unidad/{{ $act->id_actividad }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-outline-danger"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="text-center text-muted py-3">Sin actividades</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <form action="/seguimientos-unidad/{{ $seguimiento->id_seguimiento }}/actividades" method="POST">
                    @csrf
                    <textarea name="descripcion" class="form-control form-control-sm mb-2" rows="2" placeholder="Descripción..." required></textarea>
                    <select name="id_compromiso_origen" class="form-control form-control-sm mb-2">
                        <option value="">Sin compromiso origen</option>
                        @foreach($seguimiento->compromisos as $comp)
                            <option value="{{ $comp->id_compromiso }}">{{ Str::limit($comp->descripcion, 40) }}</option>
                        @endforeach
                    </select>
                    <div class="d-flex">
                        <select name="estado" class="form-control form-control-sm mr-2">
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En proceso</option>
                            <option value="completada">Completada</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<a href="/seguimientos-unidad" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Volver</a>
<a href="/unidades/{{ $seguimiento->id_unidad }}" class="btn btn-success ml-2"><i class="fas fa-industry mr-1"></i> Ver Unidad</a>
@endsection
