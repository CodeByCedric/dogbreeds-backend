<?php

use App\Http\Controllers\DogsAPIController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/dogs', [DogsAPIController::class, 'index']);
Route::get('/dogs/{id}', [DogsAPIController::class, 'show']);
Route::post('/dogs', [DogsAPIController::class, 'store']);
Route::put('/dogs/{id}', [DogsAPIController::class, 'update']);
Route::delete('/dogs/{id}', [DogsAPIController::class, 'destroy']);
