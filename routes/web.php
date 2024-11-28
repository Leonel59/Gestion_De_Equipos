<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\parametroController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\AsignacionesController;
use App\Http\Controllers\ObjetoController;
use App\Http\Controllers\SuministrosController;
use App\Http\Controllers\ProductoMantenimientoController;
use App\Http\Controllers\ServiciosMantenimientosController;
use App\Http\Controllers\ReportController;
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
    Route::resource('objetos',ObjetoController::class)->names('objetos');
    Route::resource('preguntas',PreguntaController::class)->names('preguntas');
    Route::resource('empleados',EmpleadoController::class)->names('empleados');
    Route::resource('equipos',EquiposController::class)->names('equipos');
    Route::resource('servicios', ServiciosMantenimientosController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('facturas', FacturaController::class);
    Route::resource('asignaciones', AsignacionesController::class)->names('asignaciones');
    Route::resource('suministros', SuministrosController::class)->names('suministros');
    Route::resource('productos', ProductoMantenimientoController::class);

//Equipos rutas// 

Route::get('/equipos/{id_equipo}/propiedades', [EquiposController::class, 'mostrarPropiedades'])->name('equipos.propiedades');
Route::get('/verificar-codigo-equipo', [EquiposController::class, 'verificarCodigoEquipo']);
Route::put('/equipos/{id}', [EquiposController::class, 'update'])->name('equipos.update');

Route::get('bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
Route::get('/bitacoras/download/{id}', [BitacoraController::class, 'download'])->name('bitacoras.download');
//RUTAS PREGUNTAS DE SEGURIDAD

Route::get('security-answer', [SecurityAnswerController::class, 'showForm'])->name('security.answer.form');
Route::post('security-answer', [SecurityAnswerController::class, 'checkAnswer'])->name('security.answer');

//RUTAS DE REPORTES// 
Route::get('/reportes', [ReportController::class, 'index'])->name('reportes.index');
Route::get('/reportes/equipos', [ReportController::class, 'equiposReport'])->name('reportes.equipos');
Route::get('/reportes/empleados', [ReportController::class, 'empleadosReport'])->name('reportes.empleados'); 
Route::get('/reportes/servicios', [ReportController::class, 'servicioMantenimientoReport'])->name('reportes.servicios');
Route::get('/reportes/proveedores', [ReportController::class, 'proveedorFacturaReport'])->name('reportes.proveedores');
Route::get('/reportes/asignaciones', [ReportController::class, 'asignacionesReport'])->name('reportes.asignaciones'); 
//Rutas Empleados//
Route::put('/empleados/{id}', [EmpleadoController::class, 'update'])->name('empleados.update');

Route::get('/formulario-sucursal', [SucursalController::class, 'mostrarFormulario']);
Route::get('/formulario-area', [AreasController::class, 'mostrarFormulario']);
Route::get('/get-areas/{id_sucursal}', [EmpleadoController::class, 'getAreasBySucursal'])->name('get.areas');

//RUTAS DE ASIGNACIONES//
Route::post('/asignaciones/actualizar-cantidad', [AsignacionesController::class, 'actualizarCantidad']);
Route::get('/asignaciones/empleados/{id_sucursal}', [AsignacionesController::class, 'getEmpleadosBySucursal']);
Route::get('/get-area-by-empleado/{empleadoId}/{sucursalId}', [AsignacionesController::class, 'getAreaByEmpleado']);
Route::get('/asignaciones/empleados/{id}/areas', [AsignacionesController::class, 'getEmpleadoArea'])->name('asignaciones.empleado.area');
Route::get('/asignaciones/areas/{id_sucursal}', [AsignacionesController::class, 'getAreasBySucursal']);
Route::get('/asignaciones/empleados/{id}/areas', [AsignacionesController::class, 'getEmpleadoArea']);
});


