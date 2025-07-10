<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('type', 'student')->paginate(15);
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
        
        return view('students.show', compact('id'));
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
