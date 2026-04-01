<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Emprendedor — SSISTEMALED</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background: #f4f6f9; }
        .registro-card { max-width: 720px; margin: 40px auto; }
    </style>
</head>
<body>
<div class="container">
    <div class="registro-card">
        <div class="text-center mb-4">
            <h2><i class="fas fa-rocket text-warning"></i> SSISTEMALED</h2>
            <p class="text-muted">Registro de Emprendedor</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="/registro-emprendedor" method="POST">
                    @csrf

                    <h5 class="mb-3 text-primary"><i class="fas fa-user mr-1"></i> Datos Personales</h5>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Apellidos <span class="text-danger">*</span></label>
                            <input type="text" name="apellidos" value="{{ old('apellidos') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>C.I. <span class="text-danger">*</span></label>
                            <input type="text" name="ci" value="{{ old('ci') }}" class="form-control" required>
                            <small class="form-text text-muted">Será tu usuario de acceso.</small>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Edad</label>
                            <input type="number" name="edad" value="{{ old('edad') }}" class="form-control" min="1" max="120">
                        </div>
                        <div class="form-group col-md-5">
                            <label>Sexo</label>
                            <select name="sexo" class="form-control">
                                <option value="">— Seleccionar —</option>
                                <option value="M" {{ old('sexo') === 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('sexo') === 'F' ? 'selected' : '' }}>Femenino</option>
                                <option value="Otro" {{ old('sexo') === 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Celular</label>
                            <input type="text" name="celular" value="{{ old('celular') }}" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Correo electrónico</label>
                            <input type="email" name="correo" value="{{ old('correo') }}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}" class="form-control">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Carrera</label>
                            <input type="text" name="carrera" value="{{ old('carrera') }}" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Año de Estudio</label>
                            <input type="text" name="año_estudio" value="{{ old('año_estudio') }}" class="form-control">
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3 text-primary"><i class="fas fa-rocket mr-1"></i> Emprendimiento</h5>

                    <div class="form-group">
                        <label>Emprendimiento al que perteneces <span class="text-danger">*</span></label>
                        <select name="id_emprendimiento" class="form-control" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($emprendimientos as $e)
                                <option value="{{ $e->id_emprendimiento }}" {{ old('id_emprendimiento') == $e->id_emprendimiento ? 'selected' : '' }}>
                                    {{ $e->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <hr>
                    <h5 class="mb-3 text-primary"><i class="fas fa-lock mr-1"></i> Contraseña de Acceso</h5>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="contrasena" class="form-control" required minlength="6">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="contrasena_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="/login" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Ya tengo cuenta</a>
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="fas fa-user-plus mr-1"></i> Registrarme
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
