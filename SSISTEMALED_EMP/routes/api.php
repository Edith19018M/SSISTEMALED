<?php

use Illuminate\Support\Facades\Route;

// Controllers Autenticación
use App\Http\Controllers\AuthController;

// Controllers territoriales
use App\Http\Controllers\RolController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\UsuarioController;

// Controllers de Emprendimientos
use App\Http\Controllers\CategoriaEmprendimientoController;
use App\Http\Controllers\EmprendimientoController;
use App\Http\Controllers\EmprendedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FormularioInscripcionController;
use App\Http\Controllers\EntrevistaController;
use App\Http\Controllers\PlanNegocioController;

// Controllers de Seguimiento Emprendimientos
use App\Http\Controllers\SeguimientoEmprendimientoController;
use App\Http\Controllers\CompromisoEmprendimientoController;
use App\Http\Controllers\ActividadEmprendimientoController;
use App\Http\Controllers\HistorialEmprendimientoController;

// Controllers de Asesorías
use App\Http\Controllers\AsesoriaController;
use App\Http\Controllers\CompromisoAsesoriaController;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// === AUTENTICACIÓN (Con protección) ===
Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/change-password', [AuthController::class, 'changePassword']);

        // === GESTIÓN TERRITORIAL ===
        Route::apiResource('roles', RolController::class);
        Route::apiResource('regiones', RegionController::class);
        Route::apiResource('municipios', MunicipioController::class);
        Route::apiResource('usuarios', UsuarioController::class);

        // === EMPRENDIMIENTOS ===
        Route::apiResource('categorias-emprendimiento', CategoriaEmprendimientoController::class);
        Route::get('categorias-emprendimiento/{id}/emprendimientos', [CategoriaEmprendimientoController::class, 'emprendimientos']);

        Route::apiResource('emprendimientos', EmprendimientoController::class);
        Route::get('emprendimientos/{id}/seguimientos', [EmprendimientoController::class, 'seguimientos']);
        Route::get('emprendimientos/{id}/asesorias', [EmprendimientoController::class, 'asesorias']);

        Route::apiResource('emprendedores', EmprendedorController::class);
        Route::post('emprendedores/{id}/asociar-emprendimiento', [EmprendedorController::class, 'asociarEmprendimiento']);

        Route::apiResource('productos', ProductoController::class);
        Route::get('emprendimientos/{id}/productos', [ProductoController::class, 'porEmprendimiento']);

        // === SELECCIÓN DE EMPRENDIMIENTOS ===
        Route::apiResource('formularios-inscripcion', FormularioInscripcionController::class);
        Route::get('emprendimientos/{id}/formularios', [FormularioInscripcionController::class, 'porEmprendimiento']);

        Route::apiResource('entrevistas', EntrevistaController::class);
        Route::get('emprendimientos/{id}/entrevistas', [EntrevistaController::class, 'porEmprendimiento']);

        Route::apiResource('planes-negocio', PlanNegocioController::class);
        Route::get('emprendimientos/{id}/planes-negocio', [PlanNegocioController::class, 'porEmprendimiento']);

        // === SEGUIMIENTO DE EMPRENDIMIENTOS ===
        Route::apiResource('seguimientos-emprendimiento', SeguimientoEmprendimientoController::class);
        Route::get('seguimientos-emprendimiento/{id}/compromisos', [SeguimientoEmprendimientoController::class, 'compromisos']);
        Route::get('seguimientos-emprendimiento/{id}/actividades', [SeguimientoEmprendimientoController::class, 'actividades']);

        Route::apiResource('compromisos-emprendimiento', CompromisoEmprendimientoController::class);
        Route::get('compromisos-emprendimiento/{id}/actividades', [CompromisoEmprendimientoController::class, 'actividades']);

        Route::apiResource('actividades-emprendimiento', ActividadEmprendimientoController::class);

        Route::apiResource('historial-emprendimiento', HistorialEmprendimientoController::class);
        Route::get('emprendimientos/{id}/historial', [HistorialEmprendimientoController::class, 'porEmprendimiento']);

        // === ASESORÍAS ===
        Route::apiResource('asesorias', AsesoriaController::class);
        Route::get('asesorias/{id}/compromisos', [AsesoriaController::class, 'compromisos']);

        Route::apiResource('compromisos-asesoria', CompromisoAsesoriaController::class);
        Route::get('asesorias/{id}/compromisos-relacionados', [CompromisoAsesoriaController::class, 'porAsesoria']);
    });
