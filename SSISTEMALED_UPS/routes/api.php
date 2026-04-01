<?php

use Illuminate\Support\Facades\Route;

// Controllers Autenticación
use App\Http\Controllers\AuthController;

// Controllers territoriales
use App\Http\Controllers\RolController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\UsuarioController;

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
