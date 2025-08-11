<?php

namespace App\Http\Controllers;

use App\Exports\AllStudentExcel;
use Illuminate\Http\Request;
use App\Models\Petition;
use App\Models\StudentData;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Exports\StudentsExport;
use App\Models\Speciality;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
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
    public function export()
    {
        if (!in_array(auth()->user()->type, ['admin', 'dekan'])) {
            abort(403);
        }
        return Excel::download(new StudentsExport, 'students.xlsx');
    }
    public function exportAll()
    {
        return Excel::download(new AllStudentExcel, 'studentsAll.xlsx');
    }
    public function gpaExport()
    {
        if (!in_array(auth()->user()->type, ['admin', 'dekan'])) {
            abort(403);
        }
        return Excel::download(new \App\Exports\GpaExport, 'gpa.xlsx');
    }
}
