@extends('layouts.admin')
@section('content')
<style>
    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* GPA color coding */
    .gpa-excellent {
        background-color: #10b981;
        color: white;
    }
    .gpa-good {
        background-color: #3b82f6;
        color: white;
    }
    .gpa-average {
        background-color: #f59e0b;
        color: white;
    }
    .gpa-poor {
        background-color: #ef4444;
        color: white;
    }
</style>
<div class="container">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-700 mb-4 md:mb-0">
                <i class="fas fa-user-graduate mr-2"></i>Student Management System
            </h1>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search name, passport, ID number..."
                        class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        id="searchInput">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md overflow-hidden custom-scrollbar">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Photo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID Number
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Full Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Passport
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Education Form
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Education Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Group
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                GPA
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="studentTableBody">
                        @foreach($students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ $student->image}}" alt="Student Photo" class="w-10 h-10 rounded-full">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->student_id_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->passport }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->education_form }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->education_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->group }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 rounded-full {{ 
                                    $student->avg_gpa >= 3.5 ? 'gpa-excellent' : 
                                    ($student->avg_gpa >= 2.5 ? 'gpa-good' : 
                                    ($student->avg_gpa >= 1.5 ? 'gpa-average' : 'gpa-poor')) }}">
                                    {{ number_format($student->avg_gpa, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('students.show', $student->id) }}" class="text-indigo-600 hover:text-indigo-900">Show</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="flex justify-between items-center mt-4">
            {{ $students->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
{{-- @dd($students) --}}
@endsection