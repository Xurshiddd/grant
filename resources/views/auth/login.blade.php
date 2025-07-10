<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTYSI Grant Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="https://ttysi.uz/assets/public/images/logo_black.svg" type="image/svg">
    <style>
        .login-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        .toggle-btn {
            transition: all 0.3s ease;
        }
        .toggle-btn:hover {
            transform: translateY(-2px);
        }
        @media (max-width: 768px) {
            .login-box {
                flex-direction: column;
            }
            .logo-section {
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 login-container">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden login-box flex max-w-4xl w-full">
        <!-- Logo Section -->
        <div class="logo-section bg-blue-600 flex flex-col items-center justify-center p-8 text-white md:w-1/2">
            <div class="mb-6">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-graduation-cap text-blue-600 text-4xl"></i>
                </div>
            </div>
            <h1 class="text-3xl font-bold mb-2 text-center">Toshkent To'qimachilik va yengil sanoat instituti</h1>
            <p class="text-blue-100 text-center">Talabalar uchun ta'lim grantiga ariza topshirish platformasi</p>
            <div class="mt-8">
                <div class="flex space-x-4">
                    <a href="https://facebook.com" class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center hover:bg-blue-700 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://t.me/yourchannel" class="w-12 h-12 rounded-full bg-blue-400 flex items-center justify-center hover:bg-blue-600 transition"><i class="fab fa-telegram"></i></a>
                    <a href="https://youtube.com" class="w-12 h-12 rounded-full bg-red-500 flex items-center justify-center hover:bg-red-700 transition"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        
        <!-- Login Form Section -->
        <div class="p-8 md:w-1/2 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center" id="form-title">Xodimlar uchun kirish</h2>
            
            <!-- Staff Login Form -->
            <form id="staff-login" class="space-y-4 hidden" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Elektron pochta</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email" class="w-full pl-10 pr-4 py-2 border rounded-lg input-field focus:outline-none focus:border-blue-500" placeholder="email@institut.uz" required>
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Parol</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password" class="w-full pl-10 pr-4 py-2 border rounded-lg input-field focus:outline-none focus:border-blue-500" placeholder="********" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility('password')">
                            <i class="fas fa-eye text-gray-400 hover:text-blue-500"></i>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">Eslab qolish</label>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Kirish
                </button>
            </form>
            
            <!-- Student Login OAuth -->
            <div id="student-login" class="space-y-4">
                <p class="text-gray-700 text-center">
                    Talabalar HEMIS orqali tizimga kirishlari mumkin.
                </p>
                <a href="{{ route('hemis.redirect') }}"
                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300 flex items-center justify-center">
                <i class="fas fa-university mr-2"></i> HEMIS orqali kirish
            </a>
        </div>
        
        <div class="mt-6 text-center">
            <button id="toggle-login" class="text-blue-600 hover:text-blue-800 font-medium toggle-btn flex items-center justify-center mx-auto">
                <i class="fas fa-exchange-alt mr-2"></i> Talabalar uchun kirish
            </button>
        </div>
    </div>
</div>

<script>
    // Sahifa yuklanganda formani sozlash
    window.addEventListener('DOMContentLoaded', function() {
        formTitle.textContent = "Talabalar uchun kirish";
        toggleBtn.innerHTML = '<i class="fas fa-exchange-alt mr-2"></i> Xodimlar uchun kirish';
    });
    
    const toggleBtn = document.getElementById('toggle-login');
    const staffForm = document.getElementById('staff-login');
    const studentForm = document.getElementById('student-login');
    const formTitle = document.getElementById('form-title');
    let isStudentLogin = true;
    
    toggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        isStudentLogin = !isStudentLogin;
        if (isStudentLogin) {
            staffForm.classList.add('hidden');
            studentForm.classList.remove('hidden');
            formTitle.textContent = "Talabalar uchun kirish";
            toggleBtn.innerHTML = '<i class="fas fa-exchange-alt mr-2"></i> Xodimlar uchun kirish';
        } else {
            studentForm.classList.add('hidden');
            staffForm.classList.remove('hidden');
            formTitle.textContent = "Xodimlar uchun kirish";
            toggleBtn.innerHTML = '<i class="fas fa-exchange-alt mr-2"></i> Talabalar uchun kirish';
        }
    });
    
    function togglePasswordVisibility(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const eyeIcon = passwordField.nextElementSibling.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
</body>
</html>
