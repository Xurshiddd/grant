<?php

namespace App\Http\Controllers;

use App\Models\Appel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Speciality;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // 1) Validatsiya
        $validated = $request->validate([
            'education_form' => 'nullable|in:1,2,3',
            'search'         => 'nullable|string|max:255',
            'speciality'     => 'nullable|string|max:255', // bu specialities.code
        ]);
        
        $auth = $request->user();
        
        // 2) Ruxsat tekshiruvi
        if (! in_array($auth->type, ['admin', 'dekan'])) {
            abort(403);
        }
        
        // 3) Agar specialitet kodi yuborilgan bo'lsa, fakultetni olish (view uchun)
        $faculty = null;
        if (isset($validated['speciality'])) {
            $faculty = Speciality::where('code', $validated['speciality'])->value('faculty_code');
        }
        
        // 4) Queryni tuzamiz
        $studentsQuery = User::query()
        ->where('type', 'student')
        // agar dekan bo'lsa, o'z fakultetiga cheklash
        ->when($auth->type === 'dekan', function ($q) use ($auth) {
            $facultyVal = $auth->faculty;
            return $q->where('faculty', $facultyVal);
        })
        // speciality bo'yicha filter (education_direction_code -> specialities.code)
        ->when(isset($validated['speciality']), function ($q) use ($validated) {
            $specCode = $validated['speciality'];
            
            return $q->join('specialities', 'users.faculty', '=', 'specialities.faculty_code')
            ->join('student_data', 'users.id', '=', 'student_data.user_id')
            ->where('student_data.data', 'like', '%"specialty"%'.'%' . '"code":"' . $specCode . '"%')
            ->select('users.*')
            ->groupBy('users.id');
        })
        
        
        // education_form filtri
        ->when(isset($validated['education_form']), function ($q) use ($validated) {
            return match ((int) $validated['education_form']) {
                1 => $q->whereDoesntHave('petitions'),
                2 => $q->whereHas('petitions'),
                3 => $q->whereHas('petitions')->whereDoesntHave('audits', function ($qa) {
                    $qa->where('category_id', '!=', 13);
                }),
                default => $q,
            };
        })
        // qidiruv
        ->when(isset($validated['search']), function ($q) use ($validated) {
            $search = $validated['search'];
            return $q->where(function ($query) use ($search) {
                $query->where('full_name', 'like', "%{$search}%")
                ->orWhere('passport_number', 'like', "%{$search}%")
                ->orWhere('student_id_number', 'like', "%{$search}%");
            });
        });
        
        // 5) paginate va view ga yuborish
        $students = $studentsQuery->paginate(10)->withQueryString();
        
        return view('students.index', [
            'students'      => $students,
            'faculty'       => $faculty,
            'speciality'    => $validated['speciality'] ?? null,
            'educationForm' => $validated['education_form'] ?? null,
            'search'        => $validated['search'] ?? null,
        ]);
    }
    
    
    
    public function create()
    {
        return view('students.create');
    }
    
    public function store(Request $request)
    {
        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }
    
    public function show($id)
    {
        $page = 0;
        if ((int)$id <= 10) {
            $page = 1;
        } elseif ((int)$id >= 99) {
            (int)$page = substr((string)$id, 0, 2);
        }else {
            (int)$page = substr((string)$id, 0, 1);
        } 
        $student = User::findOrFail($id);
        $categories = Category::paginate(4);
        return view('students.show', compact('student', 'categories', 'page'));
    }
    
    public function edit($id)
    {
        // Logic to edit a specific student
        return view('students.edit', compact('id'));
    }
    
    public function update(Request $request, $id)
    {
        // Logic to update student data
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }
    
    public function destroy($id)
    {
        // Logic to delete a student
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
    public function appels()
    {
        $students = DB::table('users')->join('appels', 'users.id','appels.user_id')->where('users.type', 'student')->paginate(10);
        return view('students.appels', compact('students'));
    }
}
