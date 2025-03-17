<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PropertyController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index']); // Get all users
    Route::get('/users/{id}', [UserController::class, 'show']); // View single user
    Route::put('
    /users/{id}', [UserController::class, 'update']); // Update user
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete user
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/properties', [PropertyController::class, 'store']);
    Route::get('/properties', [PropertyController::class, 'index']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');




