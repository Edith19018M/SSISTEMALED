@extends('layouts.emprendedor')

@section('title', 'Mi Perfil')
@section('titulo', 'Mi Perfil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-warning card-outline text-center">
            <div class="card-body py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h4>Perfil sin vincular</h4>
                <p class="text-muted">Tu cuenta de usuario no está vinculada a ningún emprendedor en el sistema.<br>
                   Comunícate con el administrador para que realice la vinculación.</p>
                <form action="/logout" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
