@extends('layouts.app')

@section('title', 'Compras')
@section('titulo', 'Registro de Compras')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/unidades">Unidades</a></li>
    <li class="breadcrumb-item active">Compras</li>
@endsection

@section('content')
<div class="card card-outline card-danger">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-shopping-cart mr-1"></i> Compras</h3>
        <div class="card-tools d-flex">
            <form method="GET" action="/compras" class="mr-2">
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
                        <a href="/compras" class="btn btn-default"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
            <a href="/compras/create" class="btn btn-danger btn-sm"><i class="fas fa-plus"></i> Nueva</a>
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
                    <th class="text-right">Costo (Bs)</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compras as $c)
                    <tr>
                        <td>{{ $c->unidad->nombre ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $c->producto }}</td>
                        <td class="text-center">{{ $c->cantidad }}</td>
                        <td class="text-right font-weight-bold">{{ number_format($c->costo, 2) }}</td>
                        <td class="text-right">
                            <form action="/compras/{{ $c->id_compra }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta compra?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Sin compras registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $compras->links() }}</div>
</div>
@endsection
