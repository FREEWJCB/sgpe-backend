<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\MunicipalityController;

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
