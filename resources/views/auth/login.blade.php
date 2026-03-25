<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión — SSISTEMALED</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a2035 0%, #2d3a5e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            overflow: hidden;
            max-width: 420px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .login-header i { font-size: 3rem; margin-bottom: 10px; }
        .login-header h2 { font-weight: 700; font-size: 1.8rem; margin: 0; }
        .login-header p { margin: 5px 0 0; opacity: 0.8; font-size: 0.9rem; }
        .login-body { padding: 30px; background: white; }
        .btn-login {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            color: white;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            transition: opacity 0.2s;
        }
        .btn-login:hover { opacity: 0.9; color: white; }
        .form-control:focus { border-color: #007bff; box-shadow: 0 0 0 3px rgba(0,123,255,0.15); }
        .input-group-text { background: #f8f9fa; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <i class="fas fa-lightbulb"></i>
        <h2>SSISTEMALED</h2>
        <p>Sistema de Seguimiento</p>
    </div>
    <div class="login-body">
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle mr-1"></i>{{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div><i class="fas fa-times-circle mr-1"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div class="form-group">
                <label for="correo"><i class="fas fa-envelope mr-1"></i> Correo electrónico</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                    </div>
                    <input type="email"
                           name="correo"
                           id="correo"
                           class="form-control @error('correo') is-invalid @enderror"
                           value="{{ old('correo') }}"
                           placeholder="usuario@correo.com"
                           required autofocus>
                    @error('correo')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="contraseña"><i class="fas fa-lock mr-1"></i> Contraseña</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password"
                           name="contraseña"
                           id="contraseña"
                           class="form-control @error('contraseña') is-invalid @enderror"
                           placeholder="••••••••"
                           required>
                    @error('contraseña')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-login mt-2">
                <i class="fas fa-sign-in-alt mr-1"></i> Iniciar Sesión
            </button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
