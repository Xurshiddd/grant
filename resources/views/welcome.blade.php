<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TTYSI') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 2px rgba(118, 75, 162, 0.5);
        }
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-3xl">
            <div class="p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Welcome Back</h2>
                    <p class="text-gray-600 mt-2">Please sign in to your account</p>
                </div>
                
                <!-- Error message (displayed when backend sends error) -->
                <div id="error-message" class="hidden bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p id="error-text" class="text-sm text-red-600"></p>
                        </div>
                    </div>
                </div>
                
                <!-- Login Form -->
                <form id="login-form" class="space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                            <input type="text" id="username" name="username" 
                            class="input-focus pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 py-2 px-3 border" 
                            placeholder="Enter your username" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-500"></i>
                            </div>
                            <input type="password" id="password" name="password" 
                            class="input-focus pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 py-2 px-3 border" 
                            placeholder="Enter your password" required>
                            <button type="button" id="toggle-password" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Sign in
                        <span id="login-spinner" class="ml-2 hidden">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </form>
            </div>
            
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600">
                    Need an account? <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Contact administrator</a>
                </p>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');
            
            togglePassword.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    togglePassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
            
            // Form submission with error simulation (replace with actual AJAX call)
            const loginForm = document.getElementById('login-form');
            const errorMessage = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');
            const loginSpinner = document.getElementById('login-spinner');
            
            // This is where you would normally make an AJAX call to your backend
            // For demonstration, we'll simulate both success and error cases
            
            // For testing purposes: add a hash to URL to simulate error (e.g., #error)
            if (window.location.hash === '#error') {
                showError('Invalid credentials. Please check your username and password.');
            }
            
            // ...existing code...
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Show loading spinner
                loginSpinner.classList.remove('hidden');
                
                // Clear previous error
                errorMessage.classList.add('hidden');
                
                // Prepare form data
                const formData = {
                    username: document.getElementById('username').value,
                    password: document.getElementById('password').value,
                    remember: document.getElementById('remember-me').checked ? 'on' : ''
                };
                
                try {
                    const response = await fetch('{{ route('login') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(formData)
                    });
                    
                    loginSpinner.classList.add('hidden');
                    
                    if (response.ok) {
                        // Successful login, redirect
                        window.location.href = '/profile';
                    } else {
                        const data = await response.json();
                        showError(data.message || 'Login failed: Incorrect username or password');
                        loginForm.classList.add('shake');
                        setTimeout(() => {
                            loginForm.classList.remove('shake');
                        }, 500);
                    }
                } catch (error) {
                    loginSpinner.classList.add('hidden');
                    showError('Server error. Please try again.');
                    loginForm.classList.add('shake');
                    setTimeout(() => {
                        loginForm.classList.remove('shake');
                    }, 500);
                }
            });
            // ...existing code...
            
            // Function to display error messages from backend
            function showError(message) {
                errorText.textContent = message;
                errorMessage.classList.remove('hidden');
                errorMessage.classList.add('fade-in');
                
                // Hide error after 5 seconds
                setTimeout(() => {
                    errorMessage.classList.add('hidden');
                }, 5000);
            }
        });
    </script>
</body>
</html>