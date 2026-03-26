<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::delete('tasks/{task}/delete', [TaskController::class, 'destroy']);
    Route::put('/tasks/{task}/update', [TaskController::class, 'update']);
});

Route::get('/tasks', [TaskController::class, 'index']);
