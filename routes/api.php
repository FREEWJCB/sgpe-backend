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
], function($route) {
  Route::post('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
  Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
  Route::post('/me', [AuthController::class, 'me'])->name('me');
});

Route::prefix('estado')->group(function () {
  Route::get('/', [StateController::class, 'index'])->name('estado.index');
  Route::get('/{id}', [StateController::class, 'show'])->name('estado.show');
  Route::post('/', [StateController::class , 'store'])->name('estado.store');
  Route::put('/{id}', [StateController::class, 'update'])->name('estado.update');
  Route::delete('/{id}', [StateController::class, 'destroy'])->name('estado.delete');
});

Route::prefix('municipio')->group(function () {
  Route::get('/', [MunicipalityController::class, 'index'])->name('municipio.index');
  Route::get('/{id}', [MunicipalityController::class, 'show'])->name('municipio.show');
  Route::post('/', [MunicipalityController::class , 'store'])->name('municipio.store');
  Route::put('/{id}', [MunicipalityController::class, 'update'])->name('municipio.update');
  Route::delete('/{id}', [MunicipalityController::class, 'destroy'])->name('municipio.delete');
});

Route::prefix('cargo')->group(function () {
  Route::get('/', [CargoController::class, 'index'])->name('cargo.index');
  Route::get('/{id}', [CargoController::class, 'show'])->name('cargo.show');
  Route::post('/', [CargoController::class , 'store'])->name('cargo.store');
  Route::put('/{id}', [CargoController::class, 'update'])->name('cargo.update');
  Route::delete('/{id}', [CargoController::class, 'destroy'])->name('cargo.delete');
});

Route::prefix('seccion')->group(function () {
  Route::get('/', [SeccionController::class, 'index'])->name('seccion.index');
  Route::get('/{id}', [SeccionController::class, 'show'])->name('seccion.show');
  Route::post('/', [SeccionController::class , 'store'])->name('seccion.store');
  Route::put('/{id}', [SeccionController::class, 'update'])->name('seccion.update');
  Route::delete('/{id}', [SeccionController::class, 'destroy'])->name('seccion.delete');
});

Route::prefix('grado')->group(function () {
  Route::get('/', [GradoController::class, 'index'])->name('grado.index');
  Route::get('/{id}', [GradoController::class, 'show'])->name('grado.show');
  Route::post('/', [GradoController::class , 'store'])->name('grado.store');
  Route::put('/{id}', [GradoController::class, 'update'])->name('grado.update');
  Route::delete('/{id}', [GradoController::class, 'destroy'])->name('grado.delete');
});

Route::prefix('ocupacionlaboral')->group(function () {
  Route::get('/', [Ocupacion_LaboralController::class, 'index'])->name('ocupacionlaboral.index');
  Route::get('/{id}', [Ocupacion_LaboralController::class, 'show'])->name('ocupacionlaboral.show');
  Route::post('/', [Ocupacion_LaboralController::class , 'store'])->name('ocupacionlaboral.store');
  Route::put('/{id}', [Ocupacion_LaboralController::class, 'update'])->name('ocupacionlaboral.update');
  Route::delete('/{id}', [Ocupacion_LaboralController::class, 'destroy'])->name('ocupacionlaboral.delete');
});

Route::prefix('estudiante')->group(function () {
  Route::get('/', [EstudianteController::class, 'index'])->name('estudiante.index');
  Route::get('/{id}', [EstudianteController::class, 'show'])->name('estudiante.show');
  Route::post('/', [EstudianteController::class , 'store'])->name('estudiante.store');
  Route::put('/{id}', [EstudianteController::class, 'update'])->name('estudiante.update');
  Route::delete('/{id}', [EstudianteController::class, 'destroy'])->name('estudiante.delete');
});

Route::prefix('empleado')->group(function () {
  Route::get('/', [EmpleadoController::class, 'index'])->name('empleado.index');
  Route::get('/{id}', [EmpleadoController::class, 'show'])->name('empleado.show');
  Route::post('/', [EmpleadoController::class , 'store'])->name('empleado.store');
  Route::put('/{id}', [EmpleadoController::class, 'update'])->name('empleado.update');
  Route::delete('/{id}', [EmpleadoController::class, 'destroy'])->name('empleado.delete');
});

Route::prefix('representante')->group(function () {
  Route::get('/', [RepresentanteController::class, 'index'])->name('representante.index');
  Route::get('/{id}', [RepresentanteController::class, 'show'])->name('representante.show');
  Route::post('/', [RepresentanteController::class , 'store'])->name('representante.store');
  Route::put('/{id}', [RepresentanteController::class, 'update'])->name('representante.update');
  Route::delete('/{id}', [RepresentanteController::class, 'destroy'])->name('representante.delete');
});

Route::prefix('materia')->group(function () {
  Route::get('/', [MateriaController::class, 'index'])->name('materia.index');
  Route::get('/{id}', [MateriaController::class, 'show'])->name('materia.show');
  Route::post('/', [MateriaController::class , 'store'])->name('materia.store');
  Route::put('/{id}', [MateriaController::class, 'update'])->name('materia.update');
  Route::delete('/{id}', [MateriaController::class, 'destroy'])->name('materia.delete');
});

Route::get('{route}', function ($route, Request $request) {
  return response()->json([
    "error" => "Ruta no encontrada",
    "url" => $route,
    "data" => $request->headers->all(),
    "ajax" => $request->ajax()
  ],404);
})->where('route', '[A-za-z0-9*]+');
