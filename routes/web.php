<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Tipo_UsuarioController;
use App\Http\Controllers\Tipo_AlergiaController;
use App\Http\Controllers\Tipo_DiscapacidadController;
use App\Http\Controllers\AlergiaController;
use App\Http\Controllers\DiscapacidadController;
use App\Http\Controllers\ParentescoController;
use App\Http\Controllers\ParroquiaController;
use App\Http\Controllers\Periodo_EscolarController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\combo;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
    //// return view('index');
    //return view('admin.index');
//})->name('inicio');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('Tipo_Usuario', Tipo_UsuarioController::class)->except('show','edit','create');
Route::POST('/Tipos_Usuario', [Tipo_UsuarioController::class,'cargar'])->name('Tipo_Usuario.cargar');
Route::POST('/Tipo_Usuario/rellenar', [Tipo_UsuarioController::class,'mostrar'])->name('Tipo_Usuario.mostrar');

Route::resource('Tipo_Alergia', Tipo_AlergiaController::class)->except('show','edit','create');
Route::POST('/Tipos_Alergia', [Tipo_AlergiaController::class,'cargar'])->name('Tipo_Alergia.cargar');
Route::POST('/Tipo_Alergia/rellenar', [Tipo_AlergiaController::class,'mostrar'])->name('Tipo_Alergia.mostrar');

Route::resource('Tipo_Discapacidad', Tipo_DiscapacidadController::class)->except('show','edit','create');
Route::POST('/Tipos_Discapacidad', [Tipo_DiscapacidadController::class,'cargar'])->name('Tipo_Discapacidad.cargar');
Route::POST('/Tipo_Discapacidad/rellenar', [Tipo_DiscapacidadController::class,'mostrar'])->name('Tipo_Discapacidad.mostrar');

Route::resource('Alergia', AlergiaController::class)->except('show','edit','create');
Route::POST('/Alergias', [AlergiaController::class,'cargar'])->name('Alergia.cargar');
Route::POST('/Alergia/rellenar', [AlergiaController::class,'mostrar'])->name('Alergia.mostrar');

Route::resource('Discapacidad', DiscapacidadController::class)->except('show','edit','create');
Route::POST('/Discapacidades', [DiscapacidadController::class,'cargar'])->name('Discapacidad.cargar');
Route::POST('/Discapacidad/rellenar', [DiscapacidadController::class,'mostrar'])->name('Discapacidad.mostrar');

Route::resource('Parentesco', ParentescoController::class)->except('show','edit','create');
Route::POST('/Parentescos', [ParentescoController::class,'cargar'])->name('Parentesco.cargar');
Route::POST('/Parentesco/rellenar', [ParentescoController::class,'mostrar'])->name('Parentesco.mostrar');

Route::resource('Parroquia', ParroquiaController::class)->except('show','edit','create');
Route::POST('/Parroquias', [ParroquiaController::class,'cargar'])->name('Parroquia.cargar');
Route::POST('/Parroquia/rellenar', [ParroquiaController::class,'mostrar'])->name('Parroquia.mostrar');

Route::resource('Periodo_Escolar', Periodo_EscolarController::class)->except('show','edit','create');
Route::POST('/Periodos_Escolares', [Periodo_EscolarController::class,'cargar'])->name('Periodo_Escolar.cargar');
Route::POST('/Periodo_Escolar/rellenar', [Periodo_EscolarController::class,'mostrar'])->name('Periodo_Escolar.mostrar');
Route::POST('/Periodo_Escolar/empleado', [Periodo_EscolarController::class,'empleado'])->name('Periodo_Escolar.empleado');


Route::resource('Empleado', EmpleadoController::class)->except('show','edit','create');
Route::POST('/Empleados', [EmpleadoController::class,'cargar'])->name('Empleado.cargar');
Route::POST('/Empleado/rellenar', [EmpleadoController::class,'mostrar'])->name('Empleado.mostrar');

Route::resource('Usuario', UsuarioController::class)->except('show','edit','create');
Route::POST('/Usuarios', [UsuarioController::class,'cargar'])->name('Usuario.cargar');
Route::POST('/Usuario/rellenar', [UsuarioController::class,'mostrar'])->name('Usuario.mostrar');
Route::POST('/Usuario/empleado', [UsuarioController::class,'empleado'])->name('Usuario.empleado');

Route::POST('Persona', [EstudianteController::class,'consulta'])->name('Persona.consulta');

Route::resource('Inscripcion', InscripcionController::class)->except('show','edit','create');
Route::resource('Horario', HorarioController::class)->except('show','edit','create');
Route::resource('Asistencia', AsistenciaController::class)->except('show','edit','create');
Route::resource('Permiso', PermisoController::class)->except('show','edit','create');

Route::resource('combobox', combo::class)->only('store');
