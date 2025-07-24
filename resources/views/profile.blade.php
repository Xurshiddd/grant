<!DOCTYPE html>
<html lang="uz">
<head>
    <base target="_self">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <meta name="description" content="Student profile page with personal information, academic performance, and notifications.">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="shortcut icon" href="https://ttysi.uz/assets/public/images/logo_black.svg" type="image/svg">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#3B82F6",
                        secondary: "#1E40AF",
                        accent: "#10B981",
                        notification: "#EF4444"
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gray-50">
    <div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition
    class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md"
    >
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow">
        <strong>Success!</strong> {{ session('success') }}
    </div>
    @elseif (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow">
        <strong>Error!</strong> {{ session('error') }}
    </div>
    @endif
</div>
<header class="bg-white shadow-sm">
    <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-primary">Talaba profili</h1>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <button id="notification-btn" class="p-2 text-gray-600 hover:text-primary relative">
                    <i class="fas fa-bell text-xl"></i>
                    @if ($messages->where('is_read', 0)->count() > 0)
                        <span class="absolute -top-1 -right-1 bg-notification text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{$messages->where('is_read', 0)->count()}}</span>
                    @endif
                </button>
                <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                    <div class="p-3 border-b border-gray-200">
                        <h3 class="font-semibold">Xabarlar</h3>
                    </div>
                    <div class="max-h-60 overflow-y-auto">
                        @foreach ($messages as $msg)
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="items-start">
                                {{ $msg->subject }}
                                <p class="text-xs text-gray-500">{{ $msg->body }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="p-2 border-t border-gray-200 text-center">
                        <button class="text-sm text-primary hover:underline" onclick="document.getElementById('notification-dropdown').classList.add('hidden')" id="readAll">O'qildi</button>
                    </div>
                </div> 
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="p-2 text-gray-600 hover:text-primary">
                    Logout
                    <i class="fas fa-sign-out-alt text-xl"></i>
                </button>
            </form>
        </div>
    </nav>
</header>

<main class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Personal Information Section -->
        <div class="lg:col-span-1 bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col items-center mb-6">
                <img 
                src="{{ $user->image }}" 
                alt="Student profile photo" 
                class="w-32 h-32 rounded-full object-cover border-4 border-primary"
                loading="lazy"
                />
                <h2 class="text-2xl font-bold mt-4 text-center">{{ $user->full_name }}</h2>
            </div>
            
            <section class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-center mb-6">Talim granti uchun talabgor talaba malumotlari</h2>
                <div class="grid  gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Familya </label>
                        <input type="text" name="lastname" disabled value="{{ $user->surname }}" class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ism </label>
                        <input type="text" name="firstname" value="{{ $user->firstname }}" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fuqarolik </label>
                        <input type="text" name="citizenship" value="{{ $user->country }}" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tug'ilan sana </label>
                        <input type="text" name="birthdate" value="{{ $user->birth_date }}" disabled placeholder="dd.mm.yyyy" class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Passpor seria raqami </label>
                        <input type="text" name="passport" value="{{ $user->passport_number }}" disabled placeholder="XX1234567" class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Talim turi </label>
                        <input type="text" name="education_type" value="{{ $user->education_type }}" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kursi </label>
                        <input type="text" name="course" value="{{ $user->livel }}" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Guruhi </label>
                        <input type="text" name="group" value="{{ $user->group_name }}" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telefon raqami </label>
                        <input type="text" name="phone1" value="{{ $user->phone }}" disabled placeholder="+998" class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Main Content Area -->
        <div class="lg:col-span-3 space-y-8">
            <!-- Academic Information Section -->
             @php
                    $gpa = $user->avg_gpa ?? 3.5;
                    $gpaPercentage = min(100, ($gpa / 5) * 100); // GPA ni 5 ga nisbatan % hisoblash
                    (float)$totalScore = $user->audits->sum('new_values');
                    @endphp
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="font-semibold text-gray-700">Umumiy ball: {{($totalScore / 5) + ($gpa*16)}}</h2>
                
                <div class="space-y-6">
                    <div>
                        <h3 class="font-semibold text-gray-700">GPA</h3>
                        <div class="flex items-center mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-accent h-4 rounded-full" style="width: {{ $gpaPercentage }}%"></div>
                            </div>
                            <span class="ml-2 font-bold">{{ number_format($gpa, 2) }}</span>
                        </div>
                    </div>
                    
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-700">Akademik o'zlashtirish</h3>
                    <div class="mt-2 space-y-2">
                        <div class="flex justify-between">
                            <span>ball</span>
                            <span class="font-semibold">{{ $gpa * 16}}</span>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="flex items-center bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <span>Siz bu saytga kiganingizni o'zi ariza hisoblanadi. Qo'shimcha malumot : <a href="https://www.lex.uz/uz/docs/-7429154" target="_blank" class="mr-2.5 hover:underline">149-Qaror</a> va <a href="{{ asset('186-buyruq.pdf') }}" target="_blank" class="ml-2.5 hover:underline">Ijtimoiy faollik</a></span>
            </div>
            <div class="lg:col-span-3 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-6 border-b pb-2">Ijtimoiy faollik ko'rsatkichi baliga ega bo'lish uchun asoslovchi hujjatlarni yuklash (ixtiyoriy)</h2>
                <h4 class="underline mb-1.5">Yig'ilgan ballar: {{ $totalScore / 5 }}</h4>
                <span class="text-amber-700">Qo'yilgan baholarni umumiysini / 5 = Yig'ilgan ball</span>
                @foreach ($categories as $category)
                <form action="{{ route('petitions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6 card p-4 bg-gray-100 rounded-lg shadow-sm">
                        <h3 class="font-semibold text-gray-700">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">Maksimal ball: {{ $category->max_score }}</p>
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <input type="file" name="path[]" multiple accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.webp" class="mt-2 form-input block text-sm text-gray-500
                        file:focus:ring-2 file:focus:ring-primary file:focus:border-transparent file:border file:border-gray-300 file:bg-white file:text-sm file:font-semibold file:rounded-lg file:px-4 file:py-2
                        file:hover:bg-gray-50 file:hover:border-gray-400 file:hover:text-gray-700
                        file:transition-colors file:duration-200
                        file:cursor-pointer
                        file:focus:outline-none
                        file:focus:ring-offset-2
                        file:focus:ring-offset-white
                        file:focus:ring-primary
                        file:focus:ring-opacity-50"><span class="text-xs text-gray-500">Yuklash uchun PDF, DOC, DOCX, PNG, JPG, JPEG yoki WEBP formatidagi faylni tanlang. max 5mb</span>
                        <p class="text-sm text-yellow-500 mt-2 mb-4">Siz bu mezon uchun {{ $user->petitions->where('category_id', $category->id)->count() }} ta hujjat yuklagansiz.</p>
                        @php
                        $value = \DB::table('audits')->where('user_id', $user->id)->where('category_id', $category->id)->first();    
                        @endphp
                        <p class="text-sm text-green-500 mt-2 mb-4">{{ $value->comment ?? '' }}</p>
                        <div class="{{ $user->petitions->where('category_id', $category->id)->count() > 0 ? 'inline' : 'hidden' }}">
                        <ul class="list-none pl-5 flex justify-around items-center flex-wrap mb-2">
                            @foreach ($user->petitions->where('category_id', $category->id) as $petition)
                            <li class="group text-sm text-gray-700 p-2 bg-gray-200 rounded-lg flex items-center justify-between m-1.5">
                                <a href="{{ asset($petition->path) }}" class="text-blue-600 hover:underline" target="_blank">
                                    {{ basename($petition->path) }}
                                </a>
                                <span class="text-xs text-gray-500 ml-2">{{ $petition->created_at->format('d.m.Y') }}</span>
                                <span class="text-xs text-gray-500 ml-2">
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="O‘chirish" onclick="deletePetition({{ $petition->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                </span>
                            </li>
                            @endforeach
                        </ul>
                        </div>
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition-colors">Yuklash</button>
                    </div>
                    
                </form>
                @endforeach
                
            </div>
        </div>
        <!-- category form Section -->
        
    </div>
</main>

<footer class="bg-white border-t mt-8">
    <div class="container mx-auto px-4 py-6 text-center text-gray-600 text-sm">
        <p>© {{ date('Y') }} TTYSI Student Portal</p>

    </div>
</footer>

<script>
    // delete function prevent default form submission
    function deletePetition(id) {
    event.preventDefault(); // Prevent default form submission

    if (confirm('Are you sure you want to delete this petition?')) {
        fetch(`/petitions/${id}/delete`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Petition deleted successfully.');
                location.reload();
            } else {
                alert('Error deleting petition: ' + (data.error || 'Unknown error'));
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error deleting petition:', error);
            alert('An unexpected error occurred.');
        });
    }
}

    const notificationBtn = document.getElementById('notification-btn');
    const notificationDropdown = document.getElementById('notification-dropdown');
    
    notificationBtn.addEventListener('click', function() {
        notificationDropdown.classList.toggle('hidden');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!notificationBtn.contains(event.target) && !notificationDropdown.contains(event.target)) {
            notificationDropdown.classList.add('hidden');
        }
    });
    document.getElementById('readAll').addEventListener('click', function() {
        fetch('{{ route('messages.readAll') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                notificationDropdown.classList.add('hidden');
                location.reload();
            } else {
                alert('Error marking messages as read: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error marking messages as read:', error);
            alert('An unexpected error occurred.');
        });
    });
</script>
</body>
</html>