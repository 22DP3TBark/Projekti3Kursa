<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Admin\PropertyCrudController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index']); // Get all users
    Route::get('/users/{id}', [UserController::class, 'show']); // View single user
    Route::put('/users/{id}', [UserController::class, 'update']); // Update user
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete user

    Route::get('/property', [PropertyCrudController::class, 'index']); // Get all properties
    Route::get('/property/{id}', [PropertyCrudController::class, 'show']); // View single property
    Route::put('/property/{id}', [PropertyCrudController::class, 'update']); // Update property
    Route::delete('/property/{id}', [PropertyCrudController::class, 'delete']); // Delete property
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/properties', [PropertyController::class, 'store']);
    Route::get('/properties', [PropertyController::class, 'index']); // Fix route casing
    Route::get('properties/search', [PropertyController::class, 'search']); // Search properties
    Route::get('/profile', [AuthController::class, 'profile']); // Fetch user profile
    Route::put('/profile/update', [AuthController::class, 'updateProfile']); // Update profile info
    Route::put('/profile/update-password', [AuthController::class, 'updatePassword']); // Change password
});

Route::middleware('auth:sanctum')->get('/user/properties', [PropertyController::class, 'userProperties']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');




