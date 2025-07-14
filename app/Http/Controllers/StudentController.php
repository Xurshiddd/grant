<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // search functionality
        $search = $request->input('search');
        if ($search) {
            $students = User::where('type', 'student')
            ->where(function ($query) use ($search) {
                $query->where('full_name', 'like', '%' . $search . '%')
                ->orWhere('passport_number', 'like', '%' . $search . '%')
                ->orWhere('student_id_number', 'like', '%' . $search . '%');
            })
            ->paginate(10);
        } else {
            $students = User::where('type', 'student')->paginate(10);
        }
        return view('students.index', compact('students'));
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
