<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EmprendimientoWebController;
use App\Http\Controllers\Web\EmprendedorWebController;
use App\Http\Controllers\Web\SeguimientoEmpWebController;
use App\Http\Controllers\Web\AsesoriaWebController;
use App\Http\Controllers\Web\FormularioAsesoriaController;
use App\Http\Controllers\Web\UsuarioWebController;
use App\Http\Controllers\Web\TerritorialWebController;
use App\Http\Controllers\Web\CategoriaWebController;
use App\Http\Controllers\Web\PerfilEmprendedorController;

// ===== AUTH (públicas) =====
Route::get('/', fn() => redirect('/login'));
Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

// ===== AUTOREGISTRO EMPRENDEDOR (público) =====
Route::get('/registro-emprendedor', [EmprendedorWebController::class, 'registroPublico'])->name('emprendedor.registro');
Route::post('/registro-emprendedor', [EmprendedorWebController::class, 'registroPublicoStore']);

// ===== RUTAS PROTEGIDAS =====
Route::middleware('web.auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cambio de contraseña
    Route::get('/cambiar-contrasena', [AuthWebController::class, 'showChangePassword']);
    Route::post('/cambiar-contrasena', [AuthWebController::class, 'changePassword']);

    // ===== PERFIL EMPRENDEDOR (solo rol Emprendedor) =====
    Route::middleware('solo.emprendedor')->group(function () {
        Route::get('/mi-perfil', [PerfilEmprendedorController::class, 'index'])->name('perfil.index');
        Route::get('/mi-perfil/editar', [PerfilEmprendedorController::class, 'edit'])->name('perfil.editar');
        Route::put('/mi-perfil/editar', [PerfilEmprendedorController::class, 'update'])->name('perfil.update');
    });

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

    // ===== FORMULARIO DE ASESORÍA (reemplazo del formulario externo — todos los roles) =====
    Route::get('/asesorias/formulario', [FormularioAsesoriaController::class, 'create'])->name('asesorias.formulario');
    Route::post('/asesorias/formulario', [FormularioAsesoriaController::class, 'store']);

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

        // Categorías de Emprendimiento
        Route::get('/categorias/emprendimiento', [CategoriaWebController::class, 'indexEmprendimiento']);
        Route::post('/categorias/emprendimiento', [CategoriaWebController::class, 'storeEmprendimiento']);
        Route::put('/categorias/emprendimiento/{id}', [CategoriaWebController::class, 'updateEmprendimiento']);
        Route::delete('/categorias/emprendimiento/{id}', [CategoriaWebController::class, 'destroyEmprendimiento']);
    });
});
