@extends('layouts.emprendedor')

@section('title', 'Mi Perfil')
@section('titulo', 'Mi Perfil')

@section('breadcrumb')
    <li class="breadcrumb-item active">Mi Perfil</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">

        {{-- Datos Personales --}}
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user mr-2"></i>Datos Personales</h3>
                <div class="card-tools">
                    <a href="/mi-perfil/editar" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Nombre</dt>
                    <dd class="col-sm-8">{{ $emprendedor->nombre }} {{ $emprendedor->apellidos }}</dd>

                    <dt class="col-sm-4">Edad</dt>
                    <dd class="col-sm-8">{{ $emprendedor->edad ?? '—' }}</dd>

                    <dt class="col-sm-4">Sexo</dt>
                    <dd class="col-sm-8">{{ $emprendedor->sexo ?? '—' }}</dd>

                    <dt class="col-sm-4">C.I.</dt>
                    <dd class="col-sm-8">{{ $emprendedor->ci ?? '—' }}</dd>

                    <dt class="col-sm-4">Celular</dt>
                    <dd class="col-sm-8">{{ $emprendedor->celular ?? '—' }}</dd>

                    <dt class="col-sm-4">Correo</dt>
                    <dd class="col-sm-8">{{ $emprendedor->correo ?? '—' }}</dd>

                    <dt class="col-sm-4">Dirección</dt>
                    <dd class="col-sm-8">{{ $emprendedor->direccion ?? '—' }}</dd>

                    <dt class="col-sm-4">Carrera</dt>
                    <dd class="col-sm-8">{{ $emprendedor->carrera ?? '—' }}</dd>

                    <dt class="col-sm-4">Año de Estudio</dt>
                    <dd class="col-sm-8">{{ $emprendedor->año_estudio ?? '—' }}</dd>
                </dl>
            </div>
        </div>

    </div>

    <div class="col-md-4">

        {{-- Emprendimiento Vinculado --}}
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-rocket mr-2"></i>Mi Emprendimiento</h3>
            </div>
            <div class="card-body">
                @if($emprendedor->emprendimiento)
                    <dl>
                        <dt>Nombre</dt>
                        <dd>{{ $emprendedor->emprendimiento->nombre_emprendimiento }}</dd>

                        <dt>Código</dt>
                        <dd>{{ $emprendedor->emprendimiento->codigo ?? '—' }}</dd>

                        <dt>Estado</dt>
                        <dd>
                            <span class="badge badge-{{ $emprendedor->emprendimiento->estado === 'Activo' ? 'success' : 'secondary' }}">
                                {{ $emprendedor->emprendimiento->estado ?? '—' }}
                            </span>
                        </dd>
                    </dl>
                @else
                    <p class="text-muted">No tienes un emprendimiento vinculado aún.</p>
                @endif
            </div>
        </div>

        {{-- Código de emprendedor --}}
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-id-badge mr-2"></i>Identificación</h3>
            </div>
            <div class="card-body text-center">
                <h4 class="text-muted">Código</h4>
                <h2 class="text-primary">{{ $emprendedor->codigo ?? '—' }}</h2>
            </div>
        </div>

    </div>
</div>
@endsection
