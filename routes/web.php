<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\parametroController;
use App\Http\Controllers\ObjetosController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\AsignacionesController;
use App\Http\Controllers\ServiciosMantenimientosController;
use App\Http\Controllers\SecurityAnswerController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

    //Route::middleware([
   //'auth:sanctum',
    //config('jetstream.auth_session'),
    //'verified',
   //])->group(function () {
   // Route::get('/dashboard', function () {
   //     return view('dashboard');
  //  })->name('dashboard');

  Route::middleware(['auth', 'verified'])->group(function(){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('usuarios',UsuarioController::class)->names('usuarios');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios/store', [UsuarioController::class, 'store'])->name('usuarios.store');

Route::get('roles/{id}/delete', [RoleController::class, 'delete'])->name('roles.delete');


    Route::resource('roles',RoleController::class)->names('roles');
    Route::resource('parametros',ParametroController::class)->names('parametros');
    Route::resource('objetos',ObjetosController::class)->names('objetos');
    Route::resource('preguntas',PreguntaController::class)->names('preguntas');
    Route::resource('empleados',EmpleadoController::class)->names('empleados');
    Route::resource('equipos', EquiposController::class);
    Route::resource('servicios', ServiciosMantenimientosController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('facturas', FacturaController::class);
    Route::resource('asignaciones', AsignacionesController::class);



Route::get('bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
Route::get('/bitacoras/download/{id}', [BitacoraController::class, 'download'])->name('bitacoras.download');
//RUTAS PREGUNTAS DE SEGURIDAD

Route::get('security-answer', [SecurityAnswerController::class, 'showForm'])->name('security.answer.form');
Route::post('security-answer', [SecurityAnswerController::class, 'checkAnswer'])->name('security.answer');

});


