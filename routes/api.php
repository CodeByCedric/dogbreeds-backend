<?php

use App\Http\Controllers\Api\AuthController;
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
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);


Route::get('/dogs', [DogsAPIController::class, 'index']);
Route::get('/dogs/{id}', [DogsAPIController::class, 'show']);
Route::post('/dogs', [DogsAPIController::class, 'store']);
Route::put('/dogs/{id}', [DogsAPIController::class, 'update']);
Route::delete('/dogs/{id}', [DogsAPIController::class, 'destroy']);
