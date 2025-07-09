<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grant Ariza Platformasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="bg-blue-50 min-h-screen font-sans">
    <!-- Navbar -->
    <header class="bg-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center px-6 py-5">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 400; height: 80px; border-radius: 15px;">
            </div>
            <nav class="space-x-6 text-gray-700 font-medium hidden md:block">
                <a href="#" class="text-blue-600">Bosh sahifa</a>
                <a href="#">Grant haqida</a>
                <a href="#">Ijtimoiy faollik</a>
                <a href="#">Registrator ofisi</a>
            </nav>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-5 py-2 rounded-full shadow hover:bg-blue-700">Ariza topshirish</a>
        </div>
    </header>
    @if (session('success') || $errors->has('error'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md"
    >
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow text-center">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @elseif ($errors->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow text-center">
                <strong>Xatolik!</strong> {{ $errors->first('error') }}
            </div>
        @endif
    </div>
@endif

<!-- Alert -->
<div class="bg-red-500 text-white text-center py-2 font-medium">
    <div class="container mx-auto flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        <span>Arizalar 20-iyul 23:59 gacha qabul qilinadi</span>
    </div>
</div>

<!-- Hero Section -->
<section class="py-16 px-6 bg-gradient-to-b from-blue-50 to-white">
    <div class="container mx-auto flex flex-col-reverse lg:flex-row items-center justify-between gap-12">
        <div class="lg:w-1/2 space-y-8">
            <h1 class="text-4xl lg:text-5xl font-bold text-blue-900 leading-tight">
                2025-2026 o‘quv yili uchun grantlarni taqdim etish va qayta taqsimlash bo‘yicha maxsus elektron platforma
            </h1>
            <div class="flex flex-wrap gap-4">
                <a href="#" class="bg-blue-600 text-white px-8 py-3 rounded-full hover:bg-blue-700 transition-all duration-300 shadow-md hover:shadow-lg">Grant kvotalari</a>
                <a href="#" class="flex items-center space-x-2 text-blue-600 hover:text-blue-800 transition-colors duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4.5 3.75A1.75 1.75 0 0 1 6.25 2h7.5A1.75 1.75 0 0 1 15.5 3.75v12.5A1.75 1.75 0 0 1 13.75 18h-7.5A1.75 1.75 0 0 1 4.5 16.25V3.75zM10 5a.75.75 0 0 0 0 1.5h.008a.75.75 0 0 0 0-1.5H10zM9.25 8a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .742.648L10.75 8v4a.75.75 0 0 1-1.493.102L9.25 12V8z"/></svg>
                    <span>Video qo‘llanma</span>
                </a>
            </div>
        </div>
        <div class="lg:w-1/2 mb-10 lg:mb-0">
            <img src="{{ asset('image.png') }}" alt="Grant uchun ariza" class="w-full max-w-md mx-auto rounded-lg shadow-lg overflow-hidden">
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-white py-12 px-6">
    <div class="container mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div class="p-6 rounded-xl bg-white border border-blue-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="text-3xl font-bold text-blue-800 mb-2">1141 ta</div>
            <div class="text-gray-600">Jami talabalar</div>
        </div>
        <div class="p-4 rounded-lg bg-blue-50">
            <div class="text-2xl font-bold text-blue-800">84 ta</div>
            <div class="text-gray-600 text-sm">Kelib tushgan arizalar</div>
        </div>
        <div class="p-4 rounded-lg bg-blue-50">
            <div class="text-2xl font-bold text-blue-800">0 ta</div>
            <div class="text-gray-600 text-sm">Tasdiqlangan arizalar</div>
        </div>
        <div class="p-4 rounded-lg bg-blue-50">
            <div class="text-2xl font-bold text-blue-800">0 ta</div>
            <div class="text-gray-600 text-sm">Rad etilgan arizalar</div>
        </div>
    </div>
</section>
</body>
</html>
