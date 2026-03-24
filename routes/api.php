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

// Controllers de Unidades Productivas
use App\Http\Controllers\CategoriaUnidadController;
use App\Http\Controllers\UnidadProductivaController;
use App\Http\Controllers\ResponsableController;

// Controllers de Seguimiento Unidades
use App\Http\Controllers\SeguimientoUnidadController;
use App\Http\Controllers\CompromisoUnidadController;
use App\Http\Controllers\ActividadUnidadController;
use App\Http\Controllers\HistorialUnidadController;

// Controllers de Compras y Ventas
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;

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

        // === UNIDADES PRODUCTIVAS ===
        Route::apiResource('categorias-unidad', CategoriaUnidadController::class);
        Route::get('categorias-unidad/{id}/unidades', [CategoriaUnidadController::class, 'unidades']);

        Route::apiResource('unidades-productivas', UnidadProductivaController::class);
        Route::get('unidades-productivas/{id}/seguimientos', [UnidadProductivaController::class, 'seguimientos']);
        Route::get('unidades-productivas/{id}/compras', [UnidadProductivaController::class, 'compras']);
        Route::get('unidades-productivas/{id}/ventas', [UnidadProductivaController::class, 'ventas']);
        Route::post('unidades-productivas/{id}/asociar-responsable', [UnidadProductivaController::class, 'asociarResponsable']);

        Route::apiResource('responsables', ResponsableController::class);
        Route::get('responsables/{id}/unidades', [ResponsableController::class, 'unidades']);

        // === SEGUIMIENTO DE UNIDADES ===
        Route::apiResource('seguimientos-unidad', SeguimientoUnidadController::class);
        Route::get('seguimientos-unidad/{id}/compromisos', [SeguimientoUnidadController::class, 'compromisos']);
        Route::get('seguimientos-unidad/{id}/actividades', [SeguimientoUnidadController::class, 'actividades']);

        Route::apiResource('compromisos-unidad', CompromisoUnidadController::class);
        Route::get('compromisos-unidad/{id}/actividades', [CompromisoUnidadController::class, 'actividades']);

        Route::apiResource('actividades-unidad', ActividadUnidadController::class);

        // === COMPRAS Y VENTAS ===
        Route::apiResource('compras', CompraController::class);
        Route::get('unidades-productivas/{id}/compras-list', [CompraController::class, 'porUnidad']);

        Route::apiResource('ventas', VentaController::class);
        Route::get('unidades-productivas/{id}/ventas-list', [VentaController::class, 'porUnidad']);

        // === HISTORIAL DE UNIDADES ===
        Route::apiResource('historial-unidad', HistorialUnidadController::class);
        Route::get('unidades-productivas/{id}/historial', [HistorialUnidadController::class, 'porUnidad']);
    });
