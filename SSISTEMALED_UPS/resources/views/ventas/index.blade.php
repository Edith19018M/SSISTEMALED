@extends('layouts.app')

@section('title', 'Ventas')
@section('titulo', 'Registro de Ventas')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/unidades">Unidades</a></li>
    <li class="breadcrumb-item active">Ventas</li>
@endsection

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cash-register mr-1"></i> Ventas</h3>
        <div class="card-tools d-flex">
            <form method="GET" action="/ventas" class="mr-2">
                <div class="input-group input-group-sm">
                    <select name="unidad_id" class="form-control">
                        <option value="">Todas las unidades</option>
                        @foreach($unidades as $u)
                            <option value="{{ $u->id_unidad }}" {{ request('unidad_id') == $u->id_unidad ? 'selected' : '' }}>
                                {{ $u->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit"><i class="fas fa-filter"></i></button>
                        <a href="/ventas" class="btn btn-default"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
            <a href="/ventas/create" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Nueva</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Unidad</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Precio (Bs)</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $v)
                    <tr>
                        <td>{{ $v->unidad->nombre ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($v->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $v->producto }}</td>
                        <td class="text-center">{{ $v->cantidad }}</td>
                        <td class="text-right font-weight-bold text-success">{{ number_format($v->precio, 2) }}</td>
                        <td class="text-right">
                            <form action="/ventas/{{ $v->id_venta }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta venta?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Sin ventas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $ventas->links() }}</div>
</div>
@endsection
