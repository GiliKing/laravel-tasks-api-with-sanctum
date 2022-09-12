<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


// Protected route
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::resource('/tasks', TasksController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});