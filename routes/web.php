<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\parametroController;
use App\Http\Controllers\ObjetosController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\EmpleadoController;

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

    Route::middleware(['auth:sanctum','verified'])->group(function(){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('usuarios',UsuarioController::class)->names('usuarios');
    Route::resource('roles',RoleController::class)->names('roles');
    Route::resource('parametros',ParametroController::class)->names('parametros');
    Route::resource('objetos',ObjetosController::class)->names('objetos');
    Route::resource('preguntas',PreguntaController::class)->names('preguntas');
    Route::resource('empleados',EmpleadoController::class)->names('empleados');
    
Route::get('bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');


});
