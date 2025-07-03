<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/profile', function(){
    return view('profile');
});
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/list', [CategoryController::class, 'list']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
Route::post('login', [AuthController::class, 'login'])->name('login');