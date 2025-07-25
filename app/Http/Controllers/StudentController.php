<?php

namespace App\Http\Controllers;

use App\Models\Appel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
{
    // 1) Kiruvchi ma’lumotni tekshiramiz
    $validated = $request->validate([
        'education_form' => 'nullable|in:1,2,3',
        'search'         => 'nullable|string|max:255',
    ]);

    $auth = $request->user();               // Auth::user() o‘rnini bosadi

    // 2) Faqat admin va dekan kirishi mumkin
    if (! in_array($auth->type, ['admin', 'dekan'])) {
        abort(403);
    }

    // 3) Umumiy query
    $students = User::query()
        ->where('type', 'student')
        ->when($auth->type === 'dekan',     // dekan bo‘lsa, o‘z fakultetiga cheklaymiz
            fn ($q)         => $q->where('faculty', $auth->fakulty ?? $auth->faculty)
        )

        // education_form bo‘yicha filter
        ->when(isset($validated['education_form']), function ($q) use ($validated) {
            return match ((int) $validated['education_form']) {
                1 => $q->whereDoesntHave('petitions'),
                2 => $q->whereHas('petitions'),
                3 => $q->whereHas('petitions')->whereDoesntHave('audits'),
                default => $q,
            };
        })

        // qidiruv filtri
        ->when(isset($validated['search']), function ($q) use ($validated) {
            $search = $validated['search'];
            return $q->where(function ($query) use ($search) {
                $query->where('full_name',          'like', "%{$search}%")
                      ->orWhere('passport_number',  'like', "%{$search}%")
                      ->orWhere('student_id_number','like', "%{$search}%");
            });
        })

        ->paginate(10)
        ->withQueryString();

    // 4) Natijani view-ga uzatamiz
    return view('students.index', [
        'students'      => $students,
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
