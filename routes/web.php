<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HemisAuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PetitionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RejectionController;
use App\Models\Appel;
use App\Models\Category;
use App\Models\Speciality;
use App\Models\Message;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::get('/', function () {
    try {
        $response = Http::acceptJson()->get('https://student.ttyesi.uz/rest/v1/public/stat-student');
        $bakalavr = array_sum($response['data']['level']['Bakalavr']['1-kurs']) ?? 0;
        $magistr = array_sum($response['data']['level']['Magistr']['1-kurs']) ?? 0;
        $allStudent = (int)$bakalavr+(int)$magistr ?? 0;
    } catch (\Throwable $th) {
        $allStudent = 0; // Default value in case of an error
    }
    return view('welcome', [
        'allStudent' => $allStudent,
    ]);
})->name('welcome');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/students/export', [DashboardController::class, 'export'])->name('students.export');
    Route::get('/students/exportAll', [DashboardController::class, 'exportAll'])->name('students.exportAll');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('petitions', [PetitionController::class, 'store'])->name('petitions.store');
    Route::delete('petitions/{petition}/delete', [PetitionController::class, 'delete'])->name('petitions.delete');
    Route::post('appelatsiya', function(Request $request){
        Appel::updateOrInsert([
            'user_id' => Auth::id()
        ]);
        return response()->json(['message'=> 'success']);
    });
    Route::get('profile', function () {
        $user = Auth::user();
        $messages = $user->messages()->exists() ? $user->messages()->get()->reverse() : collect();
        $categories = Category::all();
        return view('profile', compact('user', 'categories', 'messages'));
    })->name('profile');
    Route::post('messages', function (Request $request) {
        Message::where('user_id', Auth::id())
        ->update(['is_read' => true]);
        return response()->json(['success' => 'All messages marked as read'], 200);
    })->name('messages.readAll');
});
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('/hemis/redirect', [HemisAuthController::class, 'redirectToHemis'])->name('hemis.redirect');
Route::get('/hemis/callback', [HemisAuthController::class, 'handleHemisCallback'])->name('hemis.callback');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/list', [CategoryController::class, 'list']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::resource('students', StudentController::class);
    Route::get('appels', [StudentController::class, 'appels'])->name('appels');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('audits', [AuditController::class, 'store'])->name('audits.store');
    Route::post('rejects', [RejectionController::class,'store'])->name('rejects.store');
    Route::get('students/faculty/{faculty}', function($faculty){
        $specialities = Speciality::where('faculty_code', $faculty)->get();
        return response()->json($specialities);
    });
    // Route::post('petitionsave', function(Request $request){
    //     if (Auth::id()!= 1) {
    //         return redirect()->back()->with('error', 'Bu siz uchun emas');
    //     }
    //     // dd($request->all());
    //     foreach ($request->file('path') as $file) {
    //         $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //         $path = 'uploads/' . $filename;
    //         $file->move(public_path('uploads'), $filename);
    //         Petition::create([
    //             'user_id' => $request->user_id,
    //             'category_id' => $request->category_id,
    //             'path' => $path,
    //             'evaluation' => 0, // default qiymat
    //         ]);
    //     }
    //     return redirect()->back()->with('success', 'Petition created successfully.');
    // })->name('petitionsave');
});
