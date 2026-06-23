<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\NotificacionController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('sesion.usuario')->group(function () {
    Route::get('/panel', [PanelController::class, 'index'])->name('panel.index');

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/pdf', [ReporteController::class, 'pdf'])->name('reportes.pdf');

    Route::get('/cambiar-password', [LoginController::class, 'mostrarFormularioCambioPassword'])->name('password.cambiar.form');
    Route::post('/cambiar-password', [LoginController::class, 'cambiarPassword'])->name('password.cambiar.guardar');

    Route::get('/cheques/{id}/estado-critico', [ChequeController::class, 'estadoCritico'])->name('cheques.estado_critico');
    Route::post('/cheques/{id}/estado-critico', [ChequeController::class, 'guardarEstadoCritico'])->name('cheques.estado_critico.guardar');

    Route::resource('cheques', ChequeController::class);
    Route::get('/bitacoras', [BitacoraController::class, 'index'])->name('bitacoras.index');

    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones/{id}/verificar', [NotificacionController::class, 'verificar'])->name('notificaciones.verificar');
    Route::post('/notificaciones/{id}/enviada', [NotificacionController::class, 'marcarEnviada'])->name('notificaciones.enviada');

    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
});