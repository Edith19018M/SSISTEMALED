<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mi Perfil — SSISTEMALED')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/mi-perfil" class="nav-link font-weight-bold">SSISTEMALED — Emprendedores</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-user-circle"></i>
                    <span class="ml-1">{{ session('usuario_nombre', 'Usuario') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <form action="/logout" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger m-2">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    {{-- Sidebar simplificado --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/mi-perfil" class="brand-link text-center">
            <span class="brand-text font-weight-bold">
                <i class="fas fa-rocket text-warning mr-1"></i> EMP
            </span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-circle fa-2x text-white"></i>
                </div>
                <div class="info ml-2">
                    <a href="#" class="d-block text-white">{{ session('usuario_nombre', 'Usuario') }}</a>
                    <small class="text-muted">Emprendedor</small>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    <li class="nav-item">
                        <a href="/mi-perfil" class="nav-link {{ request()->is('mi-perfil') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>Mi Perfil</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/mi-perfil/editar" class="nav-link {{ request()->is('mi-perfil/editar') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Editar Datos</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/asesorias/formulario" class="nav-link {{ request()->is('asesorias/formulario') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Registrar Asesoría</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/cambiar-contrasena" class="nav-link {{ request()->is('cambiar-contrasena') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-key"></i>
                            <p>Cambiar Contraseña</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    {{-- Content --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('titulo', 'Mi Perfil')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/mi-perfil">Inicio</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer text-sm">
        <strong>SSISTEMALED — Emprendedores</strong> &copy; {{ date('Y') }} — Sistema de Seguimiento
        <div class="float-right d-none d-sm-inline-block">
            <b>Versión</b> 1.0
        </div>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@stack('scripts')
</body>
</html>
