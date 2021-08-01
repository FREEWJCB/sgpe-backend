<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;

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
  Route::get('/', [StateController::class, 'index'])->name('index');
  Route::get('/{id}', [StateController::class, 'show'])->name('show');
  Route::post('/', [StateController::class , 'store'])->name('store');
  Route::put('/{id}', [StateController::class, 'update'])->name('update');
  Route::delete('/{id}', [StateController::class, 'destroy'])->name('delete');
});
