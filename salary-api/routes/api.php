<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserSalaryController;
use App\Http\Controllers\API\AdminController;

// User routes
Route::prefix('user')->group(function () {
    Route::post('/salary', [UserSalaryController::class, 'store']);
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/salaries', [AdminController::class, 'getAllSalaries']);
    Route::get('/salary/{userId}', [AdminController::class, 'getSalaryById']);
    Route::put('/salary/{userId}', [AdminController::class, 'updateSalary']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');