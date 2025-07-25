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
<div class="container min-h-screen min-w-full">
    
    {{-- Include the sidebar --}}
    <div class="mx-auto px-4 py-8 overflow-y-scroll max-h-[90%]">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-700 mb-4 md:mb-0">
                <i class="fas fa-user-graduate mr-2"></i>Student Management System
            </h1>
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
                                Phone
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
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->passport_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->education_form }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->education_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->group_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->phone }}</td>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="flex justify-between items-center mt-4">
        {{ $students->links() }}
    </div>
</div>
</div>
@endsection