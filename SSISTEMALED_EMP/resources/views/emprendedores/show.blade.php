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
                    <dt class="col-sm-5">Código</dt>
                    <dd class="col-sm-7"><span class="badge badge-warning">{{ $emprendedor->codigo }}</span></dd>
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
                <h3 class="card-title"><i class="fas fa-rocket mr-1"></i> Emprendimiento Asociado</h3>
            </div>
            <div class="card-body">
                @if($emprendedor->emprendimiento)
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nombre</dt>
                        <dd class="col-sm-8">
                            <a href="/emprendimientos/{{ $emprendedor->emprendimiento->id_emprendimiento }}" class="font-weight-bold">
                                {{ $emprendedor->emprendimiento->nombre }}
                            </a>
                        </dd>
                        <dt class="col-sm-4">Categoría</dt>
                        <dd class="col-sm-8">{{ $emprendedor->emprendimiento->categoria->nombre_categoria ?? '—' }}</dd>
                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8">
                            @php
                                $color = match($emprendedor->emprendimiento->estado_proceso) {
                                    'activo'     => 'success',
                                    'finalizado' => 'secondary',
                                    default      => 'warning',
                                };
                            @endphp
                            <span class="badge badge-{{ $color }}">{{ ucfirst($emprendedor->emprendimiento->estado_proceso) }}</span>
                        </dd>
                    </dl>
                    <a href="/emprendimientos/{{ $emprendedor->emprendimiento->id_emprendimiento }}"
                       class="btn btn-sm btn-outline-info mt-3">
                        <i class="fas fa-arrow-right mr-1"></i> Ver Emprendimiento
                    </a>
                @else
                    <p class="text-muted mb-0">Sin emprendimiento asociado.</p>
                @endif
            </div>
        </div>
    </div>
</div>
<a href="/emprendedores" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Volver</a>
@endsection
