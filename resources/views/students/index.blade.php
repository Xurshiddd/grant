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
<div class="container min-w-full min-h-screen flex flex-col overflow-scroll">
    <div class="px-4 py-6 flex-1 flex flex-col">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-indigo-700 text-center">
                <i class="fas fa-user-graduate mr-2"></i>Student Management System
            </h1>
        </div>
        
        <!-- Filter Form -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form action="{{ route('students.index') }}" method="GET" class="space-y-4">
                <!-- First Row: Faculty, Specialty, Education Form -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fakultet</label>
                        <select name="faculty" id="faculty" class="w-full pl-3 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" @if($faculty == null) selected @endif>Fakultet tanlang</option>
                            <option value="331-101" @if($faculty == '331-101') selected @endif>Sanoat texnologiyalari va mexanika fakulteti</option>
                            <option value="331-102" @if($faculty == '331-102') selected @endif>To'qimachilik muhandisligi fakulteti</option>
                            <option value="331-103" @if($faculty == '331-103') selected @endif>Dizayn va texnologiyalar fakulteti</option>
                            <option value="331-104" @if($faculty == '331-104') selected @endif>Iqtisodiyot fakulteti</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mutaxassislik</label>
                        <select name="speciality" id="speciality" class="w-full pl-3 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Mutaxassislik tanlang</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Holat</label>
                        <select name="education_form" class="w-full pl-3 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Hammasi</option>
                            <option value="1" @isset($educationForm) @if($educationForm == 1) selected @endif @endisset>Ariza uchun fayl yuklamaganlar</option>
                            <option value="2" @isset($educationForm) @if($educationForm == 2) selected @endif @endisset>Ariza uchun fayl yuklaganlar</option>
                            <option value="3" @isset($educationForm) @if($educationForm == 3) selected @endif @endisset>Ariza uchun fayl yuklab baholanmaganlar</option>
                        </select>
                    </div>
                </div>
                
                <!-- Second Row: Search and Buttons -->
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Qidiruv</label>
                        <div class="relative">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Ism, pasport, ID raqam bo'yicha qidiring..."
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                id="searchInput"
                            >
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <a href="{{ route('students.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>Tozalash
                        </a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>Qidirish
                        </button>
                    </div>
                </div>
            </form>
            <div class="flex justify-between items-center mt-4">
                {{ $students->links() }}
            </div>
        </div>
        
        <!-- Table Container -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden flex-1 flex flex-col mb-5">
            <div class="overflow-x-auto overflow-y-auto flex-1 custom-scrollbar">
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
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->passport_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->education_form }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->education_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->group_name }}</td>
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
</div>
</div>
<script>
    // Function to load specialties for a given faculty
    function loadSpecialties(facultyCode, selectedSpecialty = null) {
        const speciality = document.getElementById('speciality');
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Mutaxassislik tanlang';
        speciality.innerHTML = '';
        speciality.appendChild(defaultOption);
        
        if (facultyCode) {
            fetch(`/students/faculty/${facultyCode}`)
            .then(response => response.json())
            .then(data => {
                speciality.innerHTML = '';
                speciality.appendChild(defaultOption);
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.code;
                    option.textContent = item.name;
                    // Select the option if it matches the selected specialty
                    if (selectedSpecialty && item.code === selectedSpecialty) {
                        option.selected = true;
                    }
                    speciality.appendChild(option);
                });
            })
            .catch(error => {
                speciality.innerHTML = '';
                speciality.appendChild(defaultOption);
            });
        }
    }
    
    // Load specialties on page load if faculty and specialty are set
    document.addEventListener('DOMContentLoaded', function() {
        const faculty = '{{ $faculty }}';
        const specialty = '{{ $speciality }}';
        
        if (faculty && faculty !== '' && specialty && specialty !== '') {
            loadSpecialties(faculty, specialty);
        }else if (faculty && faculty !== '') {
            loadSpecialties(faculty);
        }
    });
    
    // Handle faculty change event
    document.getElementById('faculty').addEventListener('change', function() {
        const faculty = this.value;
        loadSpecialties(faculty);
    });
</script>
@endsection