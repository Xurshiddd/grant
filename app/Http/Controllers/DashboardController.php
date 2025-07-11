<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petition;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    // dd(User::find(5)->education_type);
    $usersByEducation = User::where('type', 'student')
        ->select('education_type', DB::raw('COUNT(*) AS count'))
        ->groupBy('education_type')
        ->pluck('count', 'education_type'); 
        // dd($usersByEducation);
    $petitionsByCategory = Petition::select('category_id', DB::raw('count(*) as total'))
        ->groupBy('category_id')
        ->with('category')
        ->get();

    return view('dashboard', [
        'usersByEducation'   => $usersByEducation,
        'petitionsByCategory'=> $petitionsByCategory
    ]);
}
}
