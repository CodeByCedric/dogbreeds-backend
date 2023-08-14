<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DogsAPIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/dogs', [DogsAPIController::class, 'index']);
Route::get('/dogs/{id}', [DogsAPIController::class, 'show']);

Route::get('/dogs-languages/{id}', [DogsAPIController::class, 'showWithTranslations']);
//TODO, staat voornamelijk hier voor testing purposes (niet super belangrijk dat hij in de auth group staat, maar net iets veiliger (m.b.t. id))

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::post('/dogs', [DogsAPIController::class, 'store']);
    Route::put('/dogs/{id}', [DogsAPIController::class, 'updateDogAndTranslations']);
    Route::delete('/dogs/{id}', [DogsAPIController::class, 'destroy']);

});


