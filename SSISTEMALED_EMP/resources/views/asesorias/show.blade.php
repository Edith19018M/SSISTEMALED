@extends('layouts.app')

@section('title', 'Asesoría')
@section('titulo', 'Detalle de Asesoría')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/asesorias">Asesorías</a></li>
    <li class="breadcrumb-item active">Detalle</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Información</h3>
                <div class="card-tools">
                    <a href="/asesorias/{{ $asesoria->id_asesoria }}/edit" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Emprendimiento</dt>
                    <dd class="col-sm-7">{{ $asesoria->emprendimiento->nombre ?? '—' }}</dd>
                    <dt class="col-sm-5">Fecha</dt>
                    <dd class="col-sm-7">{{ \Carbon\Carbon::parse($asesoria->fecha)->format('d/m/Y') }}</dd>
                    <dt class="col-sm-5">Horario</dt>
                    <dd class="col-sm-7">{{ $asesoria->hora_inicio }} – {{ $asesoria->hora_fin }}</dd>
                    <dt class="col-sm-5">Tipo</dt>
                    <dd class="col-sm-7"><span class="badge badge-info">{{ $asesoria->tipo }}</span></dd>
                    <dt class="col-sm-5">Temática</dt>
                    <dd class="col-sm-7">{{ $asesoria->tematica }}</dd>
                    <dt class="col-sm-5">Descripción</dt>
                    <dd class="col-sm-7">{{ $asesoria->descripcion ?? '—' }}</dd>
                    <dt class="col-sm-5">Observaciones</dt>
                    <dd class="col-sm-7">{{ $asesoria->observaciones ?? '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card card-outline card-danger">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-handshake mr-1"></i> Compromisos ({{ $asesoria->compromisos->count() }})</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        @forelse($asesoria->compromisos as $comp)
                            <tr>
                                <td>
                                    <span class="badge badge-{{ $comp->estado === 'cumplido' ? 'success' : 'warning' }} mr-2">
                                        {{ ucfirst($comp->estado) }}
                                    </span>
                                    <strong>{{ $comp->actividad }}</strong>
                                    <br><small class="text-muted">Resp: {{ $comp->responsable }} — {{ \Carbon\Carbon::parse($comp->fecha)->format('d/m/Y') }}</small>
                                </td>
                                <td class="text-right">
                                    <form action="/compromisos-asesoria/{{ $comp->id_compromiso }}" method="POST"
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
                <form action="/asesorias/{{ $asesoria->id_asesoria }}/compromisos" method="POST">
                    @csrf
                    <div class="form-group mb-1">
                        <input type="text" name="actividad" class="form-control form-control-sm"
                               placeholder="Actividad / compromiso..." required>
                    </div>
                    <div class="form-group mb-1">
                        <input type="text" name="responsable" class="form-control form-control-sm"
                               placeholder="Responsable..." required>
                    </div>
                    <div class="form-group mb-1">
                        <input type="date" name="fecha" class="form-control form-control-sm"
                               value="{{ today()->toDateString() }}" required>
                    </div>
                    <div class="d-flex">
                        <select name="estado" class="form-control form-control-sm mr-2">
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En proceso</option>
                            <option value="cumplido">Cumplido</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-plus"></i> Agregar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<a href="/asesorias" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Volver</a>
@endsection
