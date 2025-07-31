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
<div class="container mx-auto px-4 py-8 overflow-y-scroll max-h-[90%] min-w-full">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Talaba malumotlari</h1>
        <a href="{{ route('students.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-arrow-left mr-2"></i> Orqaga qaytish
        </a>
    </div>
    @php
    (float)$totalScore = $student->audits->sum('new_values');   // Jami ball
    $maxScore   = \DB::table('categories')->sum('max_score');  
    $percent    = (float)$maxScore ? ((float)$totalScore / (float)$maxScore) * 100 : 0;
    $allCount = ((float)$student->avg_gpa) * 16 + ($totalScore / 5); // Jami ballar
    @endphp
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
                        <p class="text-gray-600">Tug'ilgan sanasi: {{$student->birth_date}}</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Umumiy ball  {{$allCount}}</span>
                            {{-- <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{$student->birth_date}}</span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">{{$student->birth_date}}</span> --}}
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
                        <p class="mt-1">Fuqarolik<span class="font-medium">:</span>{{ $student->country }}</p>
                        <p class="mt-1">Telefon<span class="font-medium">:</span>{{ $student->phone }}</p>
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
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="ml-2 text-sm font-medium">
                                {{ round($percent) }}% complete
                            </span>
                        </div>
                        
                        <p class="mt-2">
                            <span class="font-medium">Overall Score:</span>
                            {{ $totalScore / 5 }}
                        </p>
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
                        <span class="text-sm font-medium text-gray-500">
                            <form action="{{ route('petitionsave') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                <input type="hidden" name="user_id" value="{{ $student->id }}">
                                <input type="file" name="path[]" multiple accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.webp">
                                <button type="submit">Submit</button>
                            </form>
                        </span>
                        <span class="text-sm font-medium text-gray-500">Eng yuqori ball: {{ $category->max_score }}</span>
                        <span class="mx-2">|</span>
                        @php
                        $value = \DB::table('audits')->where('user_id', $student->id)->where('category_id', $category->id)->first();    
                        @endphp
                        <span class="text-sm font-medium text-gray-500">Hozirgi ball: {{ $value->new_values ?? '0' }}</span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <p class="text-gray-600 mb-3">{{ $value->comment ?? ' ' }}</p>
                    <!-- Files Section -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-3">Yuklangan malumotlar</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">                            
                            @foreach ($student->petitions->where('category_id', $category->id) as $file)
                            @php
                            $pathRel   = $file->path;                      // uploads/1752172855_687009374143c.jpg
                            $basename  = basename($pathRel);               // 1752172855_687009374143c.jpg
                            $display   = \Illuminate\Support\Str::after($basename, '_');       // 687009374143c.jpg
                            $ext       = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
                            [$icon, $color] = file_icon($ext);
                            
                            $url = asset($pathRel);                        // public URL
                            @endphp
                            
                            <div class="file-preview bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas {{ $icon }} {{ $color }} text-2xl mr-3"></i>
                                    <p class="font-medium text-gray-800 truncate">{{ $display }}</p>
                                </div>
                                
                                <div class="flex justify-between text-sm">
                                    <a href="{{ $url }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    <a href="{{ $url }}" download class="text-gray-600 hover:text-gray-800">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                    
                    <!-- Rating Button -->
                    <div class="flex justify-end">
                        @if($student->petitions->where('category_id', $category->id)->count()>0)
                        <button onclick="openRatingModal('{{ $category->name }}', '{{ $category->max_score }}', '{{ $category->id }}')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center"><i class="fas fa-star mr-2"></i> Ushbu mezon bo'yicha baholash</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{ $categories->links() }}
</div>


{{-- --------------- Modal --------------- --}}
{{--with float input  assessment and comment--}}
<!-- ===== Modal Overlay ===== -->
<div id="ratingModal"
class="fixed inset-0 z-40 flex items-center justify-center bg-black/50 backdrop-blur-sm
            transition-opacity duration-300 ease-out hidden">

<!-- ===== Modal Card ===== -->
<div class="w-full max-w-lg mx-4 bg-white rounded-2xl shadow-2xl ring-1 ring-black/10
                animate-[zoomIn_.25s_ease-out]">

<!-- ===== Header ===== -->
<div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
    <h2 id="modalTitle" class="text-2xl font-semibold text-gray-800">Baholash</h2>
    <button type="button" onclick="closeRatingModal()"
    class="text-gray-400 hover:text-gray-600 transition" aria-label="Close">
    <i class="fas fa-times text-lg"></i>
</button>
</div>

<!-- ===== Form ===== -->
<form id="ratingForm" class="px-6 py-6 space-y-6">
    <input type="hidden" name="category" id="categoryName">
    <input type="hidden" name="user_id" value="{{ $student->id }}">
    <!-- Ball -->
    <div>
        <label for="score" class="block mb-1 text-sm font-medium text-gray-700">Ball</label>
        <div class="flex items-center gap-3">
            <input type="number" name="score" id="score" class="w-28 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center font-semibold text-gray-800" placeholder="0">
            <span id="max_score"class="text-sm text-gray-500 whitespace-nowrap"></span>
        </div>
    </div>
    
    <!-- Izoh -->
    <div>
        <label for="comment" class="block mb-1 text-sm font-medium text-gray-700">Izoh</label>
        <textarea name="comment" id="comment" rows="4" class="w-full resize-none px-4 py-3 border border-gray-300 rounded-lg shadow-smfocus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" placeholder="Fikrlaringizni shu yerga yozing..."></textarea>
    </div>
    
    <!-- Action buttons -->
    <div class="flex justify-end gap-3">
        <button type="button" onclick="closeRatingModal()" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition">Bekor qilish</button>
        <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">Yuborish</button>
    </div>
</form>
</div>
</div>


{{-- --------------- End of Modal --------------- --}}
{{-- --------------- Skript --------------- --}}
<script>
    /** Modalni ochish */
    function openRatingModal(category, maxScore, id) {
        document.getElementById('modalTitle').innerText = `Baholash: ${category}`;
        document.getElementById('categoryName').value   = id;
        document.getElementById('score').max            = maxScore;
        document.getElementById('max_score').innerText         = 'Eng yuqori ball' + maxScore;   // default
        
        document.getElementById('ratingModal').classList.remove('hidden');
    }
    
    /** Modalni yopish */
    function closeRatingModal() {
        document.getElementById('ratingModal').classList.add('hidden');
        document.getElementById('ratingForm').reset();
    }
    /** Form yuborilganda */
    document.getElementById('ratingForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission
        const formData = new FormData(this);
        fetch('{{ route('audits.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Baholash muvaffaqiyatli yuborildi!');
                closeRatingModal();
                // Optionally, you can refresh the page or update the UI
                location.reload();
            } else {
                alert('Xatolik yuz berdi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Xatolik yuz berdi. Iltimos, qayta urinib ko\'ring.');
        });
    });
    
    /** Modal foniga bosilganda yopish */
    window.addEventListener('click', (e) => {
        if (e.target.id === 'ratingModal') closeRatingModal();
    });
</script>
@endsection