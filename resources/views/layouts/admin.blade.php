<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="https://ttysi.uz/assets/public/images/logo_black.svg" type="image/svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <div id="sidebarToggleFloating" class="fixed left-0 top-4 z-50 hidden">
        <button class="ml-2 p-2 rounded-full bg-indigo-500 text-white shadow-lg hover:bg-indigo-600 transition-colors">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
        }
        
        .sidebar {
            transition: all 0.3s ease;
        }
        
        .sidebar-item:hover {
            background-color: rgba(79, 70, 229, 0.1);
        }
        
        .sidebar-item.active {
            background-color: rgba(79, 70, 229, 0.2);
            border-left: 4px solid var(--primary);
        }
        
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .main-content {
            transition: margin-left 0.3s ease;
        }
        .container{
            padding: 15px;
        }
    </style>

</head>
<body class="overflow-hidden">
      <div class="flex h-screen">
     @include('components.sidebar')
     @yield('content')
     <script>
        // Toggle sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarToggleFloating = document.getElementById('sidebarToggleFloating');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        function toggleSidebar() {
            sidebar.classList.toggle('hidden');
            sidebarToggleFloating.classList.toggle('hidden');
        }

        if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
        if (sidebarToggleFloating) sidebarToggleFloating.addEventListener('click', toggleSidebar);

        // Make sidebar items interactive
        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                // Close sidebar on mobile after click
                if (window.innerWidth < 768) {
                    sidebar.classList.add('hidden');
                    sidebarToggleFloating.classList.remove('hidden');
                }
            });
        });

        // Hide sidebar by default on small screens
        function handleResize() {
            if (window.innerWidth < 768) {
                sidebar.classList.add('hidden');
                sidebarToggleFloating.classList.remove('hidden');
            } else {
                sidebar.classList.remove('hidden');
                sidebarToggleFloating.classList.add('hidden');
            }
        }
        window.addEventListener('resize', handleResize);
        document.addEventListener('DOMContentLoaded', handleResize);
    </script>

        </div>
</body>
</html>