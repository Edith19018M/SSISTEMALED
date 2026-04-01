@extends('layouts.app')

@section('title', 'Editar Asesoría')
@section('titulo', 'Editar Asesoría')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/asesorias">Asesorías</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<form action="/asesorias/{{ $asesoria->id_asesoria }}" method="POST">
    @csrf @method('PUT')
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-edit mr-1"></i> Editar Asesoría</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Emprendimiento <span class="text-danger">*</span></label>
                        <select name="id_emprendimiento" class="form-control" required>
                            @foreach($emprendimientos as $e)
                                <option value="{{ $e->id_emprendimiento }}"
                                    {{ old('id_emprendimiento', $asesoria->id_emprendimiento) == $e->id_emprendimiento ? 'selected' : '' }}>
                                    {{ $e->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha <span class="text-danger">*</span></label>
                        <input type="date" name="fecha" value="{{ old('fecha', \Carbon\Carbon::parse($asesoria->fecha)->toDateString()) }}"
                               class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Hora Inicio</label>
                        <input type="time" name="hora_inicio" value="{{ old('hora_inicio', $asesoria->hora_inicio) }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Hora Fin</label>
                        <input type="time" name="hora_fin" value="{{ old('hora_fin', $asesoria->hora_fin) }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipo</label>
                        <select name="tipo" class="form-control">
                            @foreach(['Presencial', 'Virtual', 'Telefónica', 'Grupal'] as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo', $asesoria->tipo) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Temática</label>
                        <input type="text" name="tematica" value="{{ old('tematica', $asesoria->tematica) }}" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $asesoria->descripcion) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones', $asesoria->observaciones) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Actualizar</button>
            <a href="/asesorias/{{ $asesoria->id_asesoria }}" class="btn btn-secondary ml-2"><i class="fas fa-times mr-1"></i> Cancelar</a>
        </div>
    </div>
</form>
@endsection
