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
    .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        .fade-out {
            animation: fadeOut 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }
</style>
<div class="container min-h-screen min-w-full">
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow">
        <strong>Success!</strong> {{ session('success') }}
    </div>
    @elseif(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow">
        <strong>Error!</strong> {{ session('error') }}
    </div>
    @endif
    {{-- Include the sidebar --}}
    <div class="mx-auto px-4 py-8 overflow-y-scroll max-h-[90%]">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-700 mb-4 md:mb-0">
                <i class="fas fa-user-graduate mr-2"></i>Student Management System
            </h1>
        </div>
        {{-- Filter Form --}}
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form action="{{ route('grant.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <select name="faculty" id="faculty" class="w-full pl-3 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" @if($faculty == null) selected @endif>Fakultet tanlang</option>
                            <option value="331-101" @if($faculty == '331-101') selected @endif>Sanoat texnologiyalari va mexanika fakulteti</option>
                            <option value="331-102" @if($faculty == '331-102') selected @endif>To'qimachilik muhandisligi fakulteti</option>
                            <option value="331-103" @if($faculty == '331-103') selected @endif>Dizayn va texnologiyalar fakulteti</option>
                            <option value="331-104" @if($faculty == '331-104') selected @endif>Iqtisodiyot fakulteti</option>
                        </select>
                    </div>
                    
                    <div>
                        <select name="speciality" id="speciality" class="w-full pl-3 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Mutaxassislik tanlang</option>
                        </select>
                    </div>
                    <div class="flex gap-3 items-center">
                        <button type="button" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg"><a href="{{ route('grant.index') }}">Tozalash</a></button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg">Qidirish</button>
                    </div>
                </div>
            </form>
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
                                Education Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Group
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Phone
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ball
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Grant
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
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->education_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->group_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->total_score }}</td>
                            <td class="px-6 py-4 whitespace-nowrap {{ $student->grant_id ? $student->grant_type == 1 ? 'gpa-excellent' : 'gpa-good' : 'gpa-poor' }}">{{ $student->grant_id ? $student->grant_type == 1 ? 'To\'liq grant' : 'To\'liq bo\'lmagan grant' : 'Yo\'q' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button type="button" onclick="openModal({{ $student->id }})" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out"><i class="fas fa-graduation-cap mr-2"></i>Grant berish</button>
                            </td>
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
{{-- modal grant turi va comment --}}
<div id="grantModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="modal-backdrop absolute inset-0 transition-opacity fade-in" onclick="closeModal()"></div>
    
    <div class="relative w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all fade-in mx-auto">
        <!-- Modal Header -->
        <div class="bg-indigo-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white">
                    <i class="fas fa-award mr-2"></i> Grant Turi va Izoh
                </h2>
                <button onclick="closeModal()" class="text-indigo-100 hover:text-white focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6">
            <form id="grantForm">
                <input type="hidden" name="student_id" id="student_id">
                
                <!-- Grant Type Selection -->
                <div class="mb-6">
                    <label for="grant_type" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2 text-indigo-500"></i> Grant Turi
                    </label>
                    <div class="relative">
                        <select name="grant_type" required id="grant_type" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                            <option value="">Grant turini tanlang</option>
                            <option value="1">To'liq grant</option>
                            <option value="2">To'liq bo'lmagan grant</option>
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-graduation-cap text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Comment Field -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-comment-dots mr-2 text-indigo-500"></i> Izoh
                    </label>
                    <div class="relative">
                        <textarea name="comment" id="comment" rows="4" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" placeholder="Grant berish sababi..."></textarea>
                        <div class="absolute top-3 left-3">
                            <i class="fas fa-pen text-gray-400"></i>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Grant berish sababini yozib qoldiring</p>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeModal()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <i class="fas fa-times mr-2"></i> Bekor qilish
                    </button>
                    <button type="button" onclick="submitForm()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <i class="fas fa-save mr-2"></i> Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function openModal(studentId) {
            document.getElementById('student_id').value = studentId;
            const modal = document.getElementById('grantModal');
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            const modal = document.getElementById('grantModal');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            // Reset form
            document.getElementById('grantForm').reset();
        }

        // Handle form submission
        document.getElementById('grantForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm();
        });

        function submitForm() {
            const formData = new FormData(document.getElementById('grantForm'));
            fetch('/grant', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Close modal when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
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