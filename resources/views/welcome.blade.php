<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grant Ariza Platformasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="shortcut icon" href="https://ttysi.uz/assets/public/images/logo_black.svg" type="image/svg">
</head>
<body class="bg-blue-50 min-h-screen font-sans">
    <!-- Navbar -->
    <header class="bg-white shadow-lg">
        <div class="mx-auto flex justify-between items-center px-4 py-4 max-w-7xl">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('logo.png') }}" alt="Logo"
                class="w-50 h-20 rounded-xl object-contain" />
            </a>
            
            <!-- Desktop navigation -->
            <nav class="hidden md:flex space-x-6 text-gray-700 font-medium">
                <a href="/" class="hover:text-blue-600">Bosh sahifa</a>
                <a href="https://www.lex.uz/uz/docs/-7429154" target="_blank" class="hover:text-blue-600">Grant haqida</a>
                <a href="{{ asset('186-buyruq.pdf') }}" target="_blank" class="hover:text-blue-600">Ijtimoiy faollik</a>
                <a href="#" id="regoffice" class="hover:text-blue-600">Registrator ofisi</a>
            </nav>
            
            <!-- Call‑to‑action button -->
            <a href="{{ route('login') }}" class="hidden sm:inline-block bg-blue-600 text-white px-4 py-2 rounded-full shadow hover:bg-blue-700 transition">Ariza topshirish</a>
            
            <!-- Mobile hamburger -->
            <button x-data @click="$dispatch('toggle-menu')"
            class="md:hidden text-gray-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
            viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round"
            stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
    
    <!-- Mobile dropdown (Alpine.js misoli) -->
    <nav x-data="{ open: false }"
    x-on:toggle-menu.window="open = !open"
    x-show="open" x-collapse
    class="md:hidden bg-white border-t">
    <div class="px-4 py-3 space-y-2 font-medium text-gray-700">
        <a href="/" class="block hover:text-blue-600">Bosh sahifa</a>
        <a href="https://www.lex.uz/uz/docs/-7429154" target="_blank" class="block hover:text-blue-600">Grant haqida</a>
        <a href="{{ asset('186-buyruq.pdf') }}" target="_blank" class="block hover:text-blue-600">Ijtimoiy faollik</a>
        <a href="#" id="regoffice" class="block hover:text-blue-600">Registrator ofisi</a>
        <a href="{{ route('login') }}" class="block bg-blue-600 text-white text-center px-4 py-2 rounded-full hover:bg-blue-700 transition">Ariza topshirish</a>
    </div>
</nav>
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
        <span>Arizalar 10-avgust 23:59 gacha qabul qilinadi. Muddat uzaytirilgani haqida malumot -> <a href="{{ asset('GS98518497.pdf') }}" class="text-green-700">Hujjatni o'qish</a></span>
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
                <a href="{{ asset('grant.pdf') }}" class="bg-blue-600 text-white px-8 py-3 rounded-full hover:bg-blue-700 transition-all duration-300 shadow-md hover:shadow-lg">Grant kvotalari</a>
                <a href="{{ route('login') }}" class="inline-block lg:hidden bg-blue-600 text-white px-4 py-2 rounded-full shadow hover:bg-blue-700 transition">Ariza topshirish</a>
            </div>
        </div>
        <div class="lg:w-1/2 mb-10 lg:mb-0">
            <img src="{{ asset('image.png') }}" alt="Grant uchun ariza" class="w-full max-w-md mx-auto rounded-lg shadow-lg overflow-hidden">
        </div>
    </div>
</section>
<div class="bg-blue-50 py-8">
    <div class="flex lg:hidden flex-col items-center justify-center max-w-4xl mx-auto px-4">
        <div class="aspect-w-16 aspect-h-9">
            <iframe
            width="560"
            height="315"
            src="https://www.youtube.com/embed/9N_OwyJcaxU"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
    </div>
    
</div>
</div>
<!-- Stats Section -->
<section class="bg-white py-12 px-6">
    <div class="container mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div class="p-6 rounded-xl bg-white border border-blue-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="text-3xl font-bold text-blue-800 mb-2">{{ $allStudent }}</div>
            <div class="text-gray-600">Jami 1-kurs talabalar</div>
        </div>
        <div class="p-4 rounded-lg bg-blue-50">
            <div class="text-2xl font-bold text-blue-800">{{ DB::table('users')->where('type', 'student')->count() }} ta</div>
            <div class="text-gray-600 text-sm">Kelib tushgan arizalar</div>
        </div>
        <div class="p-4 rounded-lg bg-blue-50">
            <div class="text-2xl font-bold text-blue-800">0 ta</div>
            <div class="text-gray-600 text-sm">Tasdiqlangan arizalar</div>
        </div>
        <div class="p-4 rounded-lg bg-blue-50">
            <div class="text-2xl font-bold text-blue-800">{{ DB::table('rejections')->count()}} ta</div>
            <div class="text-gray-600 text-sm">Rad etilgan arizalar</div>
        </div>
    </div>
</section>
{{-- Muammolar uchun dasturchi bilan bog'lanish  --}}
<section class="bg-white py-12 px-6">
    <div class="container mx-auto text-center">
        <h2 class="text-2xl font-bold text-blue-800 mb-4">Xatoliklar uchun dasturchi bilan bog'lanish</h2>
        <p class="text-gray-600 mb-6">Agar sizda platforma bilan bog'liq xatoliklar yuz bersa, quyidagi havoladan foydalaning:</p>
        <a href="https://t.me/Muhammad_alayhissalom_ummati" target="_blank" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition-colors duration-300">Dasturchi bilan bog'lanish</a>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reofficeLink = document.getElementById('regoffice');
        reofficeLink.addEventListener('click', function (event) {
            event.preventDefault();
            alert('Registrator ofisi sahifasi jarayonda tez orada ishga tushadi.');
        });
    });
</script>
</body>
</html>
