@extends('layouts.app')

@section('title', 'Nueva Asesoría')
@section('titulo', 'Nueva Asesoría')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/asesorias">Asesorías</a></li>
    <li class="breadcrumb-item active">Nueva</li>
@endsection

@section('content')
<form action="/asesorias" method="POST">
    @csrf
    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plus mr-1"></i> Datos de la Asesoría</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Emprendimiento <span class="text-danger">*</span></label>
                        <select name="id_emprendimiento" class="form-control @error('id_emprendimiento') is-invalid @enderror" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($emprendimientos as $e)
                                <option value="{{ $e->id_emprendimiento }}"
                                    {{ (old('id_emprendimiento') ?? request('emprendimiento_id')) == $e->id_emprendimiento ? 'selected' : '' }}>
                                    {{ $e->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_emprendimiento')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha <span class="text-danger">*</span></label>
                        <input type="date" name="fecha" value="{{ old('fecha', today()->toDateString()) }}"
                               class="form-control @error('fecha') is-invalid @enderror" required>
                        @error('fecha')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Hora Inicio <span class="text-danger">*</span></label>
                        <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}"
                               class="form-control @error('hora_inicio') is-invalid @enderror" required>
                        @error('hora_inicio')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Hora Fin <span class="text-danger">*</span></label>
                        <input type="time" name="hora_fin" value="{{ old('hora_fin') }}"
                               class="form-control @error('hora_fin') is-invalid @enderror" required>
                        @error('hora_fin')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipo <span class="text-danger">*</span></label>
                        <select name="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                            <option value="">— Seleccionar —</option>
                            @foreach(['Presencial', 'Virtual', 'Telefónica', 'Grupal'] as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                            @endforeach
                        </select>
                        @error('tipo')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Temática <span class="text-danger">*</span></label>
                        <input type="text" name="tematica" value="{{ old('tematica') }}"
                               class="form-control @error('tematica') is-invalid @enderror"
                               placeholder="Tema de la asesoría" required>
                        @error('tematica')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-save mr-1"></i> Guardar
            </button>
            <a href="/asesorias" class="btn btn-secondary ml-2">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </div>
</form>
@endsection
