@extends('layouts.app')

@section('title', 'Dashboard')
@section('titulo', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- Stats Row --}}
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['emprendimientos'] }}</h3>
                <p>Emprendimientos</p>
            </div>
            <div class="icon"><i class="fas fa-rocket"></i></div>
            <a href="/emprendimientos" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['emprendedores'] }}</h3>
                <p>Emprendedores</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="/emprendedores" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['seguimientos_emp'] }}</h3>
                <p>Seguimientos</p>
            </div>
            <div class="icon"><i class="fas fa-clipboard-check"></i></div>
            <a href="/seguimientos-emprendimiento" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['usuarios'] }}</h3>
                <p>Usuarios</p>
            </div>
            <div class="icon"><i class="fas fa-user-shield"></i></div>
            <a href="/usuarios" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

{{-- Stats Row 2 --}}
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-comments"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Asesorías</span>
                <span class="info-box-number">{{ $stats['asesorias'] }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Últimos Emprendimientos --}}
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-rocket mr-1"></i> Últimos Emprendimientos</h3>
                <div class="card-tools">
                    <a href="/emprendimientos/create" class="btn btn-sm btn-info">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emprendimientos as $e)
                            <tr>
                                <td>
                                    <a href="/emprendimientos/{{ $e->id_emprendimiento }}">
                                        {{ $e->nombre }}
                                    </a>
                                </td>
                                <td>{{ $e->categoria->nombre_categoria ?? '—' }}</td>
                                <td>
                                    <span class="badge badge-{{ $e->estado_proceso === 'activo' ? 'success' : ($e->estado_proceso === 'finalizado' ? 'secondary' : 'warning') }}">
                                        {{ ucfirst($e->estado_proceso) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Sin registros</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
                <a href="/emprendimientos" class="text-sm">Ver todos →</a>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-bolt mr-1"></i> Acciones Rápidas</h3>
            </div>
            <div class="card-body">
                <a href="/emprendimientos/create" class="btn btn-info mr-2 mb-2">
                    <i class="fas fa-plus mr-1"></i> Nuevo Emprendimiento
                </a>
                <a href="/emprendedores/create" class="btn btn-warning mr-2 mb-2">
                    <i class="fas fa-plus mr-1"></i> Nuevo Emprendedor
                </a>
                <a href="/seguimientos-emprendimiento/create" class="btn btn-primary mr-2 mb-2">
                    <i class="fas fa-clipboard-check mr-1"></i> Nuevo Seguimiento
                </a>
                <a href="/asesorias/create" class="btn btn-secondary mr-2 mb-2">
                    <i class="fas fa-comments mr-1"></i> Nueva Asesoría
                </a>
                <a href="/usuarios/create" class="btn btn-danger mr-2 mb-2">
                    <i class="fas fa-user-plus mr-1"></i> Nuevo Usuario
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
