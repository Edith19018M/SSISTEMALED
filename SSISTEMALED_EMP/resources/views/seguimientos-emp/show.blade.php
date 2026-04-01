@extends('layouts.app')

@section('title', 'Seguimiento N° ' . $seguimiento->numero_seguimiento)
@section('titulo', 'Seguimiento N° ' . $seguimiento->numero_seguimiento)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/seguimientos-emprendimiento">Seguimientos</a></li>
    <li class="breadcrumb-item active">N° {{ $seguimiento->numero_seguimiento }}</li>
@endsection

@section('content')
<div class="row">
    {{-- Info --}}
    <div class="col-12 mb-3">
        <div class="callout callout-info">
            <h5><i class="fas fa-rocket mr-1"></i> {{ $seguimiento->emprendimiento->nombre ?? '—' }}</h5>
            <p class="mb-0">
                <strong>Seguimiento N°:</strong> {{ $seguimiento->numero_seguimiento }} &nbsp;|&nbsp;
                <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($seguimiento->fecha)->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    {{-- Compromisos --}}
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
                                    <span class="badge badge-{{ $comp->estado === 'cumplido' ? 'success' : ($comp->estado === 'pendiente' ? 'warning' : 'secondary') }} mr-2">
                                        {{ ucfirst($comp->estado) }}
                                    </span>
                                    {{ $comp->descripcion }}
                                </td>
                                <td class="text-right" style="width:40px">
                                    <form action="/compromisos-emprendimiento/{{ $comp->id_compromiso }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar este compromiso?')">
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
                <form action="/seguimientos-emprendimiento/{{ $seguimiento->id_seguimiento }}/compromisos" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <textarea name="descripcion" class="form-control form-control-sm" rows="2"
                                  placeholder="Descripción del compromiso..." required></textarea>
                        @error('descripcion')<small class="text-danger">{{ $message }}</small>@enderror
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

    {{-- Actividades --}}
    <div class="col-md-6">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks mr-1"></i> Actividades ({{ $seguimiento->actividades->count() }})</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        @forelse($seguimiento->actividades as $act)
                            <tr>
                                <td>
                                    <span class="badge badge-{{ $act->estado === 'completada' ? 'success' : ($act->estado === 'pendiente' ? 'warning' : 'secondary') }} mr-2">
                                        {{ ucfirst($act->estado) }}
                                    </span>
                                    {{ $act->descripcion }}
                                    @if($act->compromiso)
                                        <br><small class="text-muted"><i class="fas fa-link"></i> {{ Str::limit($act->compromiso->descripcion, 30) }}</small>
                                    @endif
                                </td>
                                <td class="text-right" style="width:40px">
                                    <form action="/actividades-emprendimiento/{{ $act->id_actividad }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar esta actividad?')">
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
                <form action="/seguimientos-emprendimiento/{{ $seguimiento->id_seguimiento }}/actividades" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <textarea name="descripcion" class="form-control form-control-sm" rows="2"
                                  placeholder="Descripción de la actividad..." required></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <select name="id_compromiso_origen" class="form-control form-control-sm">
                            <option value="">Sin compromiso origen</option>
                            @foreach($seguimiento->compromisos as $comp)
                                <option value="{{ $comp->id_compromiso }}">{{ Str::limit($comp->descripcion, 40) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex">
                        <select name="estado" class="form-control form-control-sm mr-2">
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En proceso</option>
                            <option value="completada">Completada</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Agregar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mt-2">
    <a href="/seguimientos-emprendimiento" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Volver a la lista
    </a>
    <a href="/emprendimientos/{{ $seguimiento->id_emprendimiento }}" class="btn btn-info ml-2">
        <i class="fas fa-rocket mr-1"></i> Ver Emprendimiento
    </a>
</div>
@endsection
