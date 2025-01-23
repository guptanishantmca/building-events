<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WorkController; 
// Register Route
Route::post('/register', [RegisteredUserController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
     
    Route::post('work/create', [WorkController::class, 'createJob'])->name('create'); 
     
});