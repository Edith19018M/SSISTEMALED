<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EmprendimientoWebController;
use App\Http\Controllers\Web\EmprendedorWebController;
use App\Http\Controllers\Web\SeguimientoEmpWebController;
use App\Http\Controllers\Web\AsesoriaWebController;
use App\Http\Controllers\Web\UnidadProductivaWebController;
use App\Http\Controllers\Web\ResponsableWebController;
use App\Http\Controllers\Web\SeguimientoUnidadWebController;
use App\Http\Controllers\Web\CompraVentaWebController;
use App\Http\Controllers\Web\UsuarioWebController;
use App\Http\Controllers\Web\TerritorialWebController;
use App\Http\Controllers\Web\CategoriaWebController;

// ===== AUTH (públicas) =====
Route::get('/', fn() => redirect('/login'));
Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

// ===== RUTAS PROTEGIDAS =====
Route::middleware('web.auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cambio de contraseña
    Route::get('/cambiar-contrasena', [AuthWebController::class, 'showChangePassword']);
    Route::post('/cambiar-contrasena', [AuthWebController::class, 'changePassword']);

    // ===== EMPRENDIMIENTOS (lectura: todos | escritura: solo admin) =====
    Route::get('/emprendimientos', [EmprendimientoWebController::class, 'index']);
    Route::get('/emprendimientos/create', [EmprendimientoWebController::class, 'create'])->middleware('solo.admin');
    Route::post('/emprendimientos', [EmprendimientoWebController::class, 'store'])->middleware('solo.admin');
    Route::get('/emprendimientos/{id}', [EmprendimientoWebController::class, 'show']);
    Route::get('/emprendimientos/{id}/edit', [EmprendimientoWebController::class, 'edit'])->middleware('solo.admin');
    Route::put('/emprendimientos/{id}', [EmprendimientoWebController::class, 'update'])->middleware('solo.admin');
    Route::delete('/emprendimientos/{id}', [EmprendimientoWebController::class, 'destroy'])->middleware('solo.admin');

    // ===== EMPRENDEDORES =====
    Route::resource('emprendedores', EmprendedorWebController::class)->parameters(['emprendedores' => 'id']);

    // ===== SEGUIMIENTOS EMPRENDIMIENTO (todos pueden gestionar) =====
    Route::get('/seguimientos-emprendimiento', [SeguimientoEmpWebController::class, 'index']);
    Route::get('/seguimientos-emprendimiento/create', [SeguimientoEmpWebController::class, 'create']);
    Route::post('/seguimientos-emprendimiento', [SeguimientoEmpWebController::class, 'store']);
    Route::get('/seguimientos-emprendimiento/{id}', [SeguimientoEmpWebController::class, 'show']);
    Route::delete('/seguimientos-emprendimiento/{id}', [SeguimientoEmpWebController::class, 'destroy']);

    Route::post('/seguimientos-emprendimiento/{id}/compromisos', [SeguimientoEmpWebController::class, 'storeCompromiso']);
    Route::delete('/compromisos-emprendimiento/{id}', [SeguimientoEmpWebController::class, 'destroyCompromiso']);
    Route::post('/seguimientos-emprendimiento/{id}/actividades', [SeguimientoEmpWebController::class, 'storeActividad']);
    Route::delete('/actividades-emprendimiento/{id}', [SeguimientoEmpWebController::class, 'destroyActividad']);

    // ===== ASESORÍAS (lectura: todos | escritura: coordinador+) =====
    Route::get('/asesorias', [AsesoriaWebController::class, 'index']);
    Route::get('/asesorias/{id}', [AsesoriaWebController::class, 'show']);
    Route::middleware('coordinador+')->group(function () {
        Route::get('/asesorias/create', [AsesoriaWebController::class, 'create']);
        Route::post('/asesorias', [AsesoriaWebController::class, 'store']);
        Route::get('/asesorias/{id}/edit', [AsesoriaWebController::class, 'edit']);
        Route::put('/asesorias/{id}', [AsesoriaWebController::class, 'update']);
        Route::delete('/asesorias/{id}', [AsesoriaWebController::class, 'destroy']);
        Route::post('/asesorias/{id}/compromisos', [AsesoriaWebController::class, 'storeCompromiso']);
        Route::delete('/compromisos-asesoria/{id}', [AsesoriaWebController::class, 'destroyCompromiso']);
    });

    // ===== UNIDADES PRODUCTIVAS (lectura: todos | escritura: solo admin) =====
    Route::get('/unidades', [UnidadProductivaWebController::class, 'index']);
    Route::get('/unidades/create', [UnidadProductivaWebController::class, 'create'])->middleware('solo.admin');
    Route::post('/unidades', [UnidadProductivaWebController::class, 'store'])->middleware('solo.admin');
    Route::get('/unidades/{id}', [UnidadProductivaWebController::class, 'show']);
    Route::get('/unidades/{id}/edit', [UnidadProductivaWebController::class, 'edit'])->middleware('solo.admin');
    Route::put('/unidades/{id}', [UnidadProductivaWebController::class, 'update'])->middleware('solo.admin');
    Route::delete('/unidades/{id}', [UnidadProductivaWebController::class, 'destroy'])->middleware('solo.admin');
    Route::post('/unidades/{id}/responsable', [UnidadProductivaWebController::class, 'asociarResponsable']);

    // ===== RESPONSABLES =====
    Route::resource('responsables', ResponsableWebController::class)->parameters(['responsables' => 'id']);

    // ===== SEGUIMIENTOS UNIDAD (todos pueden gestionar) =====
    Route::get('/seguimientos-unidad', [SeguimientoUnidadWebController::class, 'index']);
    Route::get('/seguimientos-unidad/create', [SeguimientoUnidadWebController::class, 'create']);
    Route::post('/seguimientos-unidad', [SeguimientoUnidadWebController::class, 'store']);
    Route::get('/seguimientos-unidad/{id}', [SeguimientoUnidadWebController::class, 'show']);
    Route::delete('/seguimientos-unidad/{id}', [SeguimientoUnidadWebController::class, 'destroy']);

    Route::post('/seguimientos-unidad/{id}/compromisos', [SeguimientoUnidadWebController::class, 'storeCompromiso']);
    Route::delete('/compromisos-unidad/{id}', [SeguimientoUnidadWebController::class, 'destroyCompromiso']);
    Route::post('/seguimientos-unidad/{id}/actividades', [SeguimientoUnidadWebController::class, 'storeActividad']);
    Route::delete('/actividades-unidad/{id}', [SeguimientoUnidadWebController::class, 'destroyActividad']);

    // ===== COMPRAS =====
    Route::get('/compras', [CompraVentaWebController::class, 'indexCompras']);
    Route::get('/compras/create', [CompraVentaWebController::class, 'createCompra']);
    Route::post('/compras', [CompraVentaWebController::class, 'storeCompra']);
    Route::delete('/compras/{id}', [CompraVentaWebController::class, 'destroyCompra']);

    // ===== VENTAS =====
    Route::get('/ventas', [CompraVentaWebController::class, 'indexVentas']);
    Route::get('/ventas/create', [CompraVentaWebController::class, 'createVenta']);
    Route::post('/ventas', [CompraVentaWebController::class, 'storeVenta']);
    Route::delete('/ventas/{id}', [CompraVentaWebController::class, 'destroyVenta']);

    // ===== ADMINISTRACIÓN (solo admin) =====
    Route::middleware('solo.admin')->group(function () {

        // Usuarios
        Route::resource('usuarios', UsuarioWebController::class)->parameters(['usuarios' => 'id']);

        // Territoriales
        Route::get('/roles', [TerritorialWebController::class, 'indexRoles']);
        Route::post('/roles', [TerritorialWebController::class, 'storeRol']);
        Route::delete('/roles/{id}', [TerritorialWebController::class, 'destroyRol']);

        Route::get('/regiones', [TerritorialWebController::class, 'indexRegiones']);
        Route::post('/regiones', [TerritorialWebController::class, 'storeRegion']);
        Route::delete('/regiones/{id}', [TerritorialWebController::class, 'destroyRegion']);

        Route::get('/municipios', [TerritorialWebController::class, 'indexMunicipios']);
        Route::post('/municipios', [TerritorialWebController::class, 'storeMunicipio']);
        Route::delete('/municipios/{id}', [TerritorialWebController::class, 'destroyMunicipio']);

        // Categorías
        Route::get('/categorias/emprendimiento', [CategoriaWebController::class, 'indexEmprendimiento']);
        Route::post('/categorias/emprendimiento', [CategoriaWebController::class, 'storeEmprendimiento']);
        Route::put('/categorias/emprendimiento/{id}', [CategoriaWebController::class, 'updateEmprendimiento']);
        Route::delete('/categorias/emprendimiento/{id}', [CategoriaWebController::class, 'destroyEmprendimiento']);

        Route::get('/categorias/unidad', [CategoriaWebController::class, 'indexUnidad']);
        Route::post('/categorias/unidad', [CategoriaWebController::class, 'storeUnidad']);
        Route::put('/categorias/unidad/{id}', [CategoriaWebController::class, 'updateUnidad']);
        Route::delete('/categorias/unidad/{id}', [CategoriaWebController::class, 'destroyUnidad']);
    });
});
