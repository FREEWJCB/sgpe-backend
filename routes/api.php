<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\Ocupacion_LaboralController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ComboboxController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Periodo_EscolarController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\NotasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
  'middleware' => 'api',
  'prefix' => 'auth'
], function() {
  Route::post('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
  Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
  Route::post('/me', [AuthController::class, 'me'])->name('me');
});

Route::prefix('estado')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [StateController::class, 'index'])->name('estado.index');
  Route::get('/busqueda={busqueda}', [StateController::class, 'search'])->name('estado.search');
  Route::get('/{id}', [StateController::class, 'show'])->name('estado.show');
  Route::post('/', [StateController::class , 'store'])->name('estado.store');
  Route::put('/{id}', [StateController::class, 'update'])->name('estado.update');
  Route::delete('/{id}', [StateController::class, 'destroy'])->name('estado.delete');
});

Route::prefix('municipio')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [MunicipalityController::class, 'index'])->name('municipio.index');
  Route::get('/busqueda={busqueda}', [MunicipalityController::class, 'search'])->name('municipio.search');
  Route::get('/{id}', [MunicipalityController::class, 'show'])->name('municipio.show');
  Route::post('/', [MunicipalityController::class , 'store'])->name('municipio.store');
  Route::put('/{id}', [MunicipalityController::class, 'update'])->name('municipio.update');
  Route::delete('/{id}', [MunicipalityController::class, 'destroy'])->name('municipio.delete');
});

Route::prefix('cargo')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [CargoController::class, 'index'])->name('cargo.index');
  Route::get('/busqueda={busqueda}', [CargoController::class, 'search'])->name('cargo.search');
  Route::get('/{id}', [CargoController::class, 'show'])->name('cargo.show');
  Route::post('/', [CargoController::class , 'store'])->name('cargo.store');
  Route::put('/{id}', [CargoController::class, 'update'])->name('cargo.update');
  Route::delete('/{id}', [CargoController::class, 'destroy'])->name('cargo.delete');
});

Route::prefix('seccion')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [SeccionController::class, 'index'])->name('seccion.index');
  Route::get('/busqueda={busqueda}', [SeccionController::class, 'search'])->name('seccion.search');
  Route::get('/{id}', [SeccionController::class, 'show'])->name('seccion.show');
  Route::post('/', [SeccionController::class , 'store'])->name('seccion.store');
  Route::put('/{id}', [SeccionController::class, 'update'])->name('seccion.update');
  Route::delete('/{id}', [SeccionController::class, 'destroy'])->name('seccion.delete');
});

Route::prefix('grado')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [GradoController::class, 'index'])->name('grado.index');
  Route::get('/busqueda={busqueda}', [GradoController::class, 'search'])->name('grado.search');
  Route::get('/{id}', [GradoController::class, 'show'])->name('grado.show');
  Route::post('/', [GradoController::class , 'store'])->name('grado.store');
  Route::put('/{id}', [GradoController::class, 'update'])->name('grado.update');
  Route::delete('/{id}', [GradoController::class, 'destroy'])->name('grado.delete');
});

Route::prefix('ocupacionlaboral')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [Ocupacion_LaboralController::class, 'index'])->name('ocupacionlaboral.index');
  Route::get('/busqueda={busqueda}', [Ocupacion_LaboralController::class, 'search'])->name('ocupacionlaboral.search');
  Route::get('/{id}', [Ocupacion_LaboralController::class, 'show'])->name('ocupacionlaboral.show');
  Route::post('/', [Ocupacion_LaboralController::class , 'store'])->name('ocupacionlaboral.store');
  Route::put('/{id}', [Ocupacion_LaboralController::class, 'update'])->name('ocupacionlaboral.update');
  Route::delete('/{id}', [Ocupacion_LaboralController::class, 'destroy'])->name('ocupacionlaboral.delete');
});

Route::prefix('estudiante')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [EstudianteController::class, 'index'])->name('estudiante.index');
  Route::get('/busqueda={busqueda}', [EstudianteController::class, 'search'])->name('estudiante.search');
  Route::get('/{id}', [EstudianteController::class, 'show'])->name('estudiante.show');
  Route::post('/', [EstudianteController::class , 'store'])->name('estudiante.store');
  Route::put('/{id}', [EstudianteController::class, 'update'])->name('estudiante.update');
  Route::delete('/{id}', [EstudianteController::class, 'destroy'])->name('estudiante.delete');
});

Route::prefix('empleado')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [EmpleadoController::class, 'index'])->name('empleado.index');
  Route::get('/busqueda={busqueda}', [EmpleadoController::class, 'search'])->name('empleado.search');
  Route::get('/{id}', [EmpleadoController::class, 'show'])->name('empleado.show');
  Route::post('/', [EmpleadoController::class , 'store'])->name('empleado.store');
  Route::put('/{id}', [EmpleadoController::class, 'update'])->name('empleado.update');
  Route::delete('/{id}', [EmpleadoController::class, 'destroy'])->name('empleado.delete');
});

Route::prefix('representante')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [RepresentanteController::class, 'index'])->name('representante.index');
  Route::get('/busqueda={busqueda}', [RepresentanteController::class, 'search'])->name('representante.search');
  Route::get('/{id}', [RepresentanteController::class, 'show'])->name('representante.show');
  Route::post('/', [RepresentanteController::class , 'store'])->name('representante.store');
  Route::put('/{id}', [RepresentanteController::class, 'update'])->name('representante.update');
  Route::delete('/{id}', [RepresentanteController::class, 'destroy'])->name('representante.delete');
});

Route::prefix('usuario')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [UsuarioController::class, 'index'])->name('usuario.index');
  Route::get('/busqueda={busqueda}', [UsuarioController::class, 'search'])->name('usuario.search');
  Route::get('/{id}', [UsuarioController::class, 'show'])->name('usuario.show');
  Route::post('/', [UsuarioController::class , 'store'])->name('usuario.store');
  Route::put('/{id}', [UsuarioController::class, 'update'])->name('usuario.update');
  Route::put('/pass/{id}', [UsuarioController::class, 'updatePassword'])->name('usuario.updatePassword');
  Route::delete('/{id}', [UsuarioController::class, 'destroy'])->name('usuario.delete');
});

Route::prefix('materia')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [MateriaController::class, 'index'])->name('materia.index');
  Route::get('/busqueda={busqueda}', [MateriaController::class, 'search'])->name('materia.search');
  Route::get('/{id}', [MateriaController::class, 'show'])->name('materia.show');
  Route::post('/', [MateriaController::class , 'store'])->name('materia.store');
  Route::put('/{id}', [MateriaController::class, 'update'])->name('materia.update');
  Route::delete('/{id}', [MateriaController::class, 'destroy'])->name('materia.delete');
});

Route::prefix('periodoescolar')->group(function () {
  Route::get('/pagination/page={page}&limit={limit}', [Periodo_EscolarController::class, 'index'])->name('periodoescolar.index');
  Route::get('/busqueda={busqueda}', [Periodo_EscolarController::class, 'search'])->name('periodoescolar.search');
  Route::get('/{id}', [Periodo_EscolarController::class, 'show'])->name('periodoescolar.show');
  Route::post('/', [Periodo_EscolarController::class , 'store'])->name('periodoescolar.store');
  Route::put('/{id}', [Periodo_EscolarController::class, 'update'])->name('periodoescolar.update');
  Route::delete('/{id}', [Periodo_EscolarController::class, 'destroy'])->name('periodoescolar.delete');
});

Route::prefix('cbbx')->group(function () {
  Route::get('estado', [ComboboxController::class, 'estado'])->name('cbbx.estado');
  Route::get('/municipio/{id}', [ComboboxController::class, 'municipio'])->name('cbbx.municipio');
  Route::get('/cargo', [ComboboxController::class , 'cargo'])->name('cbbx.cargo');
  Route::get('/ocupacionlaboral', [ComboboxController::class, 'ocupacionlaboral'])->name('cbbx.ocupacionlaboral');
  Route::get('/grado', [ComboboxController::class, 'grado'])->name( 'cbbx.grado');
  Route::get('/seccion/{id}', [ComboboxController::class, 'seccion'])->name( 'cbbx.seccion');
  Route::get('/empleado/users={users}', [ComboboxController::class, 'empleado'])->name( 'cbbx.empleado');
  Route::get('/periodoescolar', [ComboboxController::class, 'periodoescolar'])->name( 'cbbx.periodoescolar');
  Route::get('/parentescos', [ComboboxController::class, 'parentescos'])->name( 'cbbx.parentescos');
  Route::get('/materia', [ComboboxController::class, 'materia'])->name( 'cbbx.materia');
});

/* Processos */

Route::prefix('inscripcion')->group(function () {
  Route::get('/', [InscripcionController::class, 'index'])->name('inscripcion.index');
  Route::get('/busqueda={busqueda}', [InscripcionController::class, 'search'])->name('inscripcion.search');
  Route::get('/estudiante/{cedula}', [InscripcionController::class, 'estudiante'])->name('inscripcion.estudiante');
  Route::get('/representante/{cedula}', [InscripcionController::class, 'representante'])->name('inscripcion.representante');
  Route::get('/{id}', [InscripcionController::class, 'show'])->name('inscripcion.show');
  Route::post('/', [InscripcionController::class , 'store'])->name('inscripcion.store');
  Route::put('/{id}', [InscripcionController::class, 'update'])->name('inscripcion.update');
  Route::delete('/{id}', [InscripcionController::class, 'destroy'])->name('inscripcion.delete');
});

Route::prefix('asistencia')->group(function () {
  Route::get('/start={start}&end={end}&month={month}&year={year}', [AsistenciaController::class, 'index'])->name('asistencia.index');
  Route::get('/empleado/{edit}', [AsistenciaController::class, 'empleado'])->name('asistencia.empleado');
  Route::get('/{id}', [AsistenciaController::class, 'show'])->name('asistencia.show');
  Route::get('/allday/{fecha}', [AsistenciaController::class, 'showAllDay'])->name('asistencia.showAllDay');
  Route::post('/', [AsistenciaController::class , 'store'])->name('asistencia.store');
  Route::put('/{id}', [AsistenciaController::class, 'update'])->name('asistencia.update');
  Route::delete('/{id}', [AsistenciaController::class, 'destroy'])->name('asistencia.delete');
});

Route::prefix('notas')->group(function () {
  Route::get('/', [NotasController::class, 'index'])->name('notas.index');
  Route::get('/periodo={periodo}&seccion={seccion}', [NotasController::class, 'search'])->name('notas.search');
  Route::get('/{id}', [NotasController::class, 'show'])->name('notas.show');
  Route::get('/notas/{id}/{materia}', [NotasController::class, 'notas'])->name('notas.notas');
  Route::get('/seccion/{grado}', [NotasController::class, 'seccion'])->name('notas.seccion');
  Route::get('/estudiante/{id}/{materia}', [NotasController::class, 'estudiante'])->name('notas.estudiante');
  Route::post('/', [NotasController::class , 'store'])->name('notas.store');
  Route::post('/valor', [NotasController::class , 'valor'])->name('notas.valor');
  Route::put('/{id}', [NotasController::class, 'update'])->name('notas.update');
  Route::put('/uptadenotas/{id}', [NotasController::class, 'updateNotasEstudiante'])->name('notas.update');
  Route::delete('/{id}', [NotasController::class, 'destroy'])->name('notas.delete');
});

Route::get('{route}', function ($route, Request $request) {
  return response()->json([
    "error" => "Ruta no encontrada",
    "url" => $route,
    "data" => $request->headers->all(),
    "ajax" => $request->ajax()
  ], 404);
})->where('route', '[A-za-z0-9*]+');
