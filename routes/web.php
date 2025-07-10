<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HemisAuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PetitionController;
use App\Http\Controllers\DashboardController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    $response = Http::acceptJson()->get('https://student.ttyesi.uz/rest/v1/public/stat-student');
    $allStudent = array_sum($response['data']['level']['Bakalavr']['1-kurs']) ?? 0;
    return view('welcome', [
        'allStudent' => $allStudent,
    ]);
})->name('welcome');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/list', [CategoryController::class, 'list']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::resource('students', StudentController::class);
    Route::resource('petitions', PetitionController::class);
    Route::delete('petitions/{petition}/delete', [PetitionController::class, 'delete'])->name('petitions.delete');
    Route::get('profile', function () {
        $user = Auth::user();
        $categories = Category::all();
        return view('profile', compact('user', 'categories'));
    })->name('profile');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('/hemis/redirect', [HemisAuthController::class, 'redirectToHemis'])->name('hemis.redirect');
Route::get('/hemis/callback', [HemisAuthController::class, 'handleHemisCallback'])->name('hemis.callback');
