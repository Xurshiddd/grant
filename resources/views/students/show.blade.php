@extends('layouts.admin')
@section('content')
<style>
    .file-preview {
        transition: all 0.3s ease;
    }
    .file-preview:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .rating-stars {
        direction: rtl;
        unicode-bidi: bidi-override;
    }
    .rating-stars input {
        display: none;
    }
    .rating-stars label {
        color: #ddd;
        font-size: 24px;
        padding: 0 2px;
        cursor: pointer;
    }
    .rating-stars input:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #ffc107;
    }
    .modal {
        transition: opacity 0.3s ease;
    }
</style>
<div class="container mx-auto px-4 py-8 overflow-y-scroll max-h-[90%]">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Talaba malumotlari</h1>
        <a href="{{ route('students.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-arrow-left mr-2"></i> Orqaga qaytish
        </a>
    </div>
    
    <!-- User Info Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="md:flex">
            <div class="md:w-1/4 p-6 flex justify-center">
                <img class="h-48 w-48 rounded-full object-cover border-4 border-blue-100" 
                src="{{ $student->image }}" alt="User profile">
            </div>
            <div class="md:w-3/4 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $student->full_name }}</h2>
                        <p class="text-gray-600">{{$student->birth_date}}</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">{{$student->group_name}}</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{$student->birth_date}}</span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">{{$student->birth_date}}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500">Ro'yxatdan o'tish: <span class="font-medium">{{ \Carbon\Carbon::parse($student->created_at)->format('d F Y') }}</span></p>
                        <p class="text-gray-500">GPA: <span class="font-medium">{{$student->avg_gpa}}</span></p>
                    </div>
                </div>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Talaba malumoti</h3>
                        <p class="mt-1">Fuqarolik:<span class="font-medium">:</span>{{ $student->country }}</p>
                        <p class="mt-1">Telefon:<span class="font-medium">:</span>{{ $student->phone }}</p>
                        <p><span class="font-medium">Passport:</span>{{ $student->passport_number }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Talaba malumoti</h3>
                        <p class="mt-1"><span class="font-medium">Talim turi:</span>{{ $student->education_type }}</p>
                        <p class="mt-1"><span class="font-medium">Gururhi:</span>{{ $student->group_name }}</p>
                        <p><span class="font-medium">Kursi:</span> {{ $student->livel }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <div class="mt-1 flex items-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 85%"></div>
                            </div>
                            <span class="ml-2 text-sm font-medium">85% complete</span>
                        </div>
                        <p class="mt-2"><span class="font-medium">Overall Score:</span>100</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Evaluation Categories -->
    
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Mezonlar bo'yicha baholash</h2>
        <!-- Category 1 -->
        @foreach ($categories as $category)
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $category->name }}</h3>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Eng yuqori ball: {{ $category->max_score }}</span>
                        <span class="mx-2">|</span>
                        <span class="text-sm font-medium text-gray-500">Current Score: 3.5</span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <p class="text-gray-600 mb-3">Evaluation criteria for technical skills including programming languages, frameworks, and problem-solving abilities.</p>
                    <!-- Files Section -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-3">Yuklangan malumotlar</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <!-- PDF File -->
                            @foreach ( $student->petitions->where('category_id', $category->id) as $file)
                            <div class="file-preview bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-file-pdf text-red-500 text-2xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-800 truncate">{{ $file->name }}</p>
                                        <p class="text-xs text-gray-500">2.4 MB</p>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-800">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </button>
                                </div>
                            </div>
                            @endforeach
                            
                            <!-- Image File -->
                            <div class="file-preview bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-file-image text-blue-500 text-2xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-800 truncate">project-screenshot.png</p>
                                        <p class="text-xs text-gray-500">1.8 MB</p>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-800">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </button>
                                </div>
                            </div>
                            
                            <!-- DOC File -->
                            <div class="file-preview bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-file-word text-blue-700 text-2xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-800 truncate">report.docx</p>
                                        <p class="text-xs text-gray-500">3.1 MB</p>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-800">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rating Button -->
                    <div class="flex justify-end">
                        <button onclick="openRatingModal('Technical Skills', 5)" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                        <i class="fas fa-star mr-2"></i> Rate This Category
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{ $categories->links() }}
</div>


<!-- Rating Modal -->
<div id="ratingModal" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 id="modalTitle" class="text-2xl font-bold text-gray-800 mb-4">Rate Technical Skills</h3>
            
            <div class="my-6 px-4">
                <div class="rating-stars flex justify-center mb-6">
                    <!-- Stars will be added dynamically by JavaScript -->
                </div>
                
                <div class="mb-6">
                    <label for="comments" class="block text-left text-gray-700 font-medium mb-2">Comments</label>
                    <textarea id="comments" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Add your comments here..."></textarea>
                </div>
                
                <div class="flex justify-between">
                    <button onclick="closeRatingModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button onclick="submitRating()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                        <i class="fas fa-check-circle mr-2"></i> Submit Rating
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let currentCategory = '';
    let maxScore = 5;
    
    function openRatingModal(category, score) {
        currentCategory = category;
        maxScore = score;
        
        document.getElementById('modalTitle').textContent = `Rate ${category}`;
        
        // Generate star rating inputs
        const starsContainer = document.querySelector('.rating-stars');
        starsContainer.innerHTML = '';
        
        for (let i = maxScore; i >= 1; i--) {
            const input = document.createElement('input');
            input.type = 'radio';
            input.id = `star${i}`;
            input.name = 'rating';
            input.value = i;
            
            const label = document.createElement('label');
            label.htmlFor = `star${i}`;
            label.innerHTML = '★';
            
            starsContainer.appendChild(input);
            starsContainer.appendChild(label);
        }
        
        document.getElementById('ratingModal').classList.remove('hidden');
    }
    
    function closeRatingModal() {
        document.getElementById('ratingModal').classList.add('hidden');
    }
    
    function submitRating() {
        const rating = document.querySelector('input[name="rating"]:checked');
        const comments = document.getElementById('comments').value;
        
        if (!rating) {
            alert('Please select a rating before submitting.');
            return;
        }
        
        // Here you would typically send the data to your backend
        console.log(`Rating submitted for ${currentCategory}:`);
        console.log(`Score: ${rating.value}/${maxScore}`);
        console.log(`Comments: ${comments}`);
        
        // Show success message
        alert(`Rating of ${rating.value}/${maxScore} submitted for ${currentCategory}!`);
        
        // Close modal
        closeRatingModal();
        
        // Reset form
        document.getElementById('comments').value = '';
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('ratingModal');
        if (event.target === modal) {
            closeRatingModal();
        }
    }
</script>
@endsection