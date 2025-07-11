<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('type', 'student')->paginate(10);
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
        $student = User::findOrFail($id);
        $categories = Category::paginate(4);
        return view('students.show', compact('student', 'categories'));
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
