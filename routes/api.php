<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\GradoController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
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

Route::prefix('salon')->group(function () {
  Route::get('/', [SalonController::class, 'index'])->name('salon.index');
  Route::get('/{id}', [SalonController::class, 'show'])->name('salon.show');
  Route::post('/', [SalonController::class , 'store'])->name('salon.store');
  Route::put('/{id}', [SalonController::class, 'update'])->name('salon.update');
  Route::delete('/{id}', [SalonController::class, 'destroy'])->name('salon.delete');
});

Route::prefix('grado')->group(function () {
  Route::get('/', [GradoController::class, 'index'])->name('grado.index');
  Route::get('/{id}', [GradoController::class, 'show'])->name('grado.show');
  Route::post('/', [GradoController::class , 'store'])->name('grado.store');
  Route::put('/{id}', [GradoController::class, 'update'])->name('grado.update');
  Route::delete('/{id}', [GradoController::class, 'destroy'])->name('grado.delete');
});
