<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // ⚡️ 1) Кирувчи маълумотни валидация қилиб оламиз
        $validated = $request->validate([
            'education_form' => 'nullable|in:1,2,3',
            'search'         => 'nullable|string|max:255',
        ]);
        
        // ⚡️ 2) Базавий сўров
        $students = User::query()
        ->where('type', 'student')          // Бир марта ёзилади
        ->when(isset($validated['education_form']), function ($q) use ($validated) {
            // education_form бўйича фильтр
            return match ((int) $validated['education_form']) {
                1       => $q->whereDoesntHave('petitions'),
                2       => $q->whereHas('petitions'),
                3       => $q->whereHas('petitions')->whereDoesntHave('audits'),
                default => $q,
            };
        })
        ->when(isset($validated['search']), function ($q) use ($validated) {
            // search бўйича фильтр
            $search = $validated['search'];
            $q->where(fn ($q) =>
            $q->where('full_name',        'like', "%{$search}%")
            ->orWhere('passport_number','like', "%{$search}%")
            ->orWhere('student_id_number','like', "%{$search}%")
        );
    })
    // ⚡️ 3) керак бўлса eager loading / count:
    // ->withCount(['petitions','audits'])
    ->paginate(10)
    ->withQueryString();  // pagination линкларида фильтрлар сақланади
    
    return view('students.index', [
        'students'        => $students,
        'educationForm'   => $validated['education_form'] ?? null,
        'search'          => $validated['search'] ?? null,
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
}
