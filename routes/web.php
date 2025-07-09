<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HemisAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/profile', function(){
    return view('profile');
});
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/list', [CategoryController::class, 'list']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('/hemis/login', [HemisAuthController::class, 'redirectToHemis']);
Route::get('/hemis/callback', [HemisAuthController::class, 'handleHemisCallback']);