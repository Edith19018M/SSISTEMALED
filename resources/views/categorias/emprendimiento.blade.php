@extends('layouts.app')

@section('title', 'Categorías de Emprendimiento')
@section('titulo', 'Categorías de Emprendimiento')
@section('breadcrumb')
    <li class="breadcrumb-item active">Categorías Emprendimiento</li>
@endsection

@section('content')
<div class="row">
    {{-- Formulario nueva categoría --}}
    <div class="col-md-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i> Nueva Categoría</h3>
            </div>
            <div class="card-body">
                <form action="/categorias/emprendimiento" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nombre de la Categoría <span class="text-danger">*</span></label>
                        <input type="text" name="nombre_categoria" class="form-control @error('nombre_categoria') is-invalid @enderror"
                               value="{{ old('nombre_categoria') }}" placeholder="Ej: Tecnología" required maxlength="100">
                        @error('nombre_categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-info btn-block">
                        <i class="fas fa-save mr-1"></i> Guardar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Lista de categorías --}}
    <div class="col-md-8">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tags mr-1"></i> Categorías Registradas ({{ $categorias->count() }})</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th class="text-center">Emprendimientos</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $cat)
                            <tr>
                                <td>{{ $cat->id_categoria }}</td>
                                <td>
                                    {{-- Inline edit form --}}
                                    <form action="/categorias/emprendimiento/{{ $cat->id_categoria }}" method="POST"
                                          id="form-edit-{{ $cat->id_categoria }}" class="d-none">
                                        @csrf @method('PUT')
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="nombre_categoria" class="form-control"
                                                   value="{{ $cat->nombre_categoria }}" required maxlength="100">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                        onclick="cancelEdit({{ $cat->id_categoria }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <span id="text-{{ $cat->id_categoria }}">{{ $cat->nombre_categoria }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $cat->emprendimientos_count }}</span>
                                </td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                            onclick="startEdit({{ $cat->id_categoria }})" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($cat->emprendimientos_count == 0)
                                        <form action="/categorias/emprendimiento/{{ $cat->id_categoria }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar esta categoría?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-outline-danger" disabled title="Tiene emprendimientos asociados">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-tags fa-2x mb-2 d-block"></i>
                                    No hay categorías registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function startEdit(id) {
    document.getElementById('text-' + id).classList.add('d-none');
    document.getElementById('form-edit-' + id).classList.remove('d-none');
}
function cancelEdit(id) {
    document.getElementById('text-' + id).classList.remove('d-none');
    document.getElementById('form-edit-' + id).classList.add('d-none');
}
</script>
@endpush
