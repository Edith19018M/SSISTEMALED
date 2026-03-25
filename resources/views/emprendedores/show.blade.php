@extends('layouts.app')

@section('title', $emprendedor->nombre . ' ' . $emprendedor->apellidos)
@section('titulo', $emprendedor->nombre . ' ' . $emprendedor->apellidos)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/emprendedores">Emprendedores</a></li>
    <li class="breadcrumb-item active">{{ $emprendedor->nombre }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user mr-1"></i> Datos Personales</h3>
                <div class="card-tools">
                    <a href="/emprendedores/{{ $emprendedor->id_emprendedor }}/edit" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Nombre</dt>
                    <dd class="col-sm-7">{{ $emprendedor->nombre }} {{ $emprendedor->apellidos }}</dd>
                    <dt class="col-sm-5">CI</dt>
                    <dd class="col-sm-7">{{ $emprendedor->ci ?? '—' }}</dd>
                    <dt class="col-sm-5">Edad</dt>
                    <dd class="col-sm-7">{{ $emprendedor->edad ? $emprendedor->edad . ' años' : '—' }}</dd>
                    <dt class="col-sm-5">Sexo</dt>
                    <dd class="col-sm-7">{{ $emprendedor->sexo ?? '—' }}</dd>
                    <dt class="col-sm-5">Celular</dt>
                    <dd class="col-sm-7">{{ $emprendedor->celular ?? '—' }}</dd>
                    <dt class="col-sm-5">Correo</dt>
                    <dd class="col-sm-7">{{ $emprendedor->correo ?? '—' }}</dd>
                    <dt class="col-sm-5">Dirección</dt>
                    <dd class="col-sm-7">{{ $emprendedor->direccion ?? '—' }}</dd>
                    <dt class="col-sm-5">Carrera</dt>
                    <dd class="col-sm-7">{{ $emprendedor->carrera ?? '—' }}</dd>
                    <dt class="col-sm-5">Año Estudio</dt>
                    <dd class="col-sm-7">{{ $emprendedor->año_estudio ?? '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-rocket mr-1"></i> Emprendimientos Asociados ({{ $emprendedor->emprendimientos->count() }})</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Emprendimiento</th>
                            <th>Categoría</th>
                            <th class="text-center">Responsable Principal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emprendedor->emprendimientos as $emp)
                            <tr>
                                <td><a href="/emprendimientos/{{ $emp->id_emprendimiento }}">{{ $emp->nombre }}</a></td>
                                <td>{{ $emp->categoria->nombre_categoria ?? '—' }}</td>
                                <td class="text-center">
                                    @if($emp->pivot->es_responsable_principal)
                                        <span class="badge badge-success">Sí</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Sin emprendimientos asociados</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<a href="/emprendedores" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Volver</a>
@endsection
