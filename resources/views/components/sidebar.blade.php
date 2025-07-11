<div class="sidebar w-64 bg-white shadow-lg flex flex-col">
    <!-- Logo -->
    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center">
                <i class="fas fa-cog text-white"></i>
            </div>
            <span class="font-bold text-lg text-indigo-600">AdminPro</span>
        </div>
        <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    
    <!-- User Profile -->
    <div class="p-4 border-b border-gray-200 flex items-center space-x-3">
        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
            <i class="fas fa-user text-indigo-500"></i>
        </div>
        <div>
            <p class="font-medium">{{ auth()->user()->firstname }}</p>
            <p class="text-xs text-gray-500">Admin</p>
        </div>
    </div>
    
    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto py-2">
        <div class="px-2 space-y-1">
            <a href="{{ route('dashboard') }}"
            @class([
            'sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-md',
            'text-indigo-700 bg-indigo-100' => request()->routeIs('dashboard'),
            'text-gray-600 hover:text-indigo-600' => !request()->routeIs('dashboard'),
            ])>
            <i class="fas fa-tachometer-alt mr-3"
            :class="request()->routeIs('dashboard') ? 'text-indigo-700' : 'text-gray-500'"></i>
            Dashboard
        </a>
        
        <a href="{{ route('students.index') }}"
        @class([
        'sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-md',
        'text-indigo-700 bg-indigo-100' => request()->routeIs('students.*'),
        'text-gray-600 hover:text-indigo-600' => !request()->routeIs('students.*'),
        ])>
        <i class="fas fa-users mr-3"
        :class="request()->routeIs('students.*') ? 'text-indigo-700' : 'text-gray-500'"></i>
        Students
    </a>
    
    <a href="{{ route('categories.index') }}"
    @class([
    'sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-md',
    'text-indigo-700 bg-indigo-100' => request()->routeIs('categories.*'),
    'text-gray-600 hover:text-indigo-600' => !request()->routeIs('categories.*'),
    ])>
    <i class="fas fa-box mr-3"
    :class="request()->routeIs('categories.*') ? 'text-indigo-700' : 'text-gray-500'"></i>
    Mezonlar
</a>

</div>
</div>

<!-- Footer -->
<div class="p-4 border-t border-gray-200">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 rounded-md">
            <i class="fas fa-sign-out-alt mr-2"></i>
            Logout
        </button>
    </form>
</div>
</div>

<!-- Main Content -->
<div class="main-content flex-1 flex flex-col overflow-hidden">
    <!-- Top Navigation -->
    <header class="bg-white shadow-sm">
        <div class="px-6 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
            </div>
            <div class="flex items-center space-x-4">
                <button class="p-2 rounded-full text-gray-500 hover:bg-gray-100">
                    <i class="fas fa-bell"></i>
                </button>
                <button class="p-2 rounded-full text-gray-500 hover:bg-gray-100">
                    <i class="fas fa-envelope"></i>
                </button>
                <div class="relative">
                    <button class="flex items-center space-x-2 focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-user text-indigo-500"></i>
                        </div>
                        <span class="hidden md:inline-block font-medium">Admin</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>