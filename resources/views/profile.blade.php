<!DOCTYPE html>
<html lang="en">
<head>
    <base target="_self">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <meta name="description" content="Student profile page with personal information, achievements, and messages">
    <script src="https://cdn.tailwindcss.com"></script>
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
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-primary">Student Profile</h1>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button id="notification-btn" class="p-2 text-gray-600 hover:text-primary relative">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-notification text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button>
                    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                        <div class="p-3 border-b border-gray-200">
                            <h3 class="font-semibold">Notifications</h3>
                        </div>
                        <div class="max-h-60 overflow-y-auto">
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 text-primary">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">New grade posted for Web Development</p>
                                        <p class="text-xs text-gray-500">2 hours ago</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 text-accent">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">Your achievement was approved</p>
                                        <p class="text-xs text-gray-500">1 day ago</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 text-secondary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">Upcoming deadline: Project submission</p>
                                        <p class="text-xs text-gray-500">3 days ago</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="p-2 border-t border-gray-200 text-center">
                            <a href="#" class="text-sm text-primary font-medium">View All Notifications</a>
                        </div>
                    </div>
                </div>
                <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-secondary transition">Edit Profile</button>
                <button class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 transition">Logout</button>
            </div>
        </nav>
    </header>
    
    <main class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Personal Information Section -->
            <div class="lg:col-span-1 bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col items-center mb-6">
                    <img 
                    src="https://picsum.photos/200?random=1" 
                    alt="Student profile photo" 
                    class="w-32 h-32 rounded-full object-cover border-4 border-primary"
                    loading="lazy"
                    />
                    <h2 class="text-2xl font-bold mt-4">John Doe</h2>
                    <p class="text-gray-600">Computer Science Student</p>
                </div>
                
                <section class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-center mb-6">Talim granti uchun talabgor talaba malumotlari</h2>
                    <form class="grid  gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Familya <span class="text-red-500">*</span></label>
                            <input type="text" name="lastname" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ism <span class="text-red-500">*</span></label>
                            <input type="text" name="firstname" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ism <span class="text-red-500">*</span></label>
                            <input type="text" name="fathername" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fuqarolik <span class="text-red-500">*</span></label>
                            <input type="text" name="citizenship" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tug'ilan sana <span class="text-red-500">*</span></label>
                            <input type="text" name="birthdate" disabled placeholder="dd.mm.yyyy" class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Passpor seria raqami <span class="text-red-500">*</span></label>
                            <input type="text" name="passport" disabled placeholder="XX1234567" class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Talim turi <span class="text-red-500">*</span></label>
                            <input type="text" name="education_type" disabled placeholder="Бакалавр/магистр" class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kursi <span class="text-red-500">*</span></label>
                            <input type="text" name="course" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Guruhi <span class="text-red-500">*</span></label>
                            <input type="text" name="group" disabled class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Telefon raqami <span class="text-red-500">*</span></label>
                            <input type="text" name="phone1" disabled placeholder="+998" class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Telefon raqami (qo'shimcha)</label>
                            <input type="text" name="phone2" disabled placeholder="+998" class="mt-1 block w-full border border-blue-400 rounded-md shadow-sm px-3 py-2" />
                        </div>
                    </form>
                </section>
            </div>
            
            <!-- Main Content Area -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Academic Information Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-6 border-b pb-2">Academic Information</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <h3 class="font-semibold text-gray-700">Current GPA</h3>
                            <div class="flex items-center mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-4">
                                    <div class="bg-accent h-4 rounded-full" style="width: 85%"></div>
                                </div>
                                <span class="ml-2 font-bold">3.7</span>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-gray-700">Semester Progress</h3>
                            <div class="mt-2 space-y-2">
                                <div class="flex justify-between">
                                    <span>Fall 2022</span>
                                    <span class="font-semibold">3.5</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Spring 2023</span>
                                    <span class="font-semibold">3.8</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Fall 2023</span>
                                    <span class="font-semibold">3.9</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-gray-700">Current Courses</h3>
                            <ul class="mt-2 space-y-1">
                                <li>• Data Structures and Algorithms</li>
                                <li>• Database Systems</li>
                                <li>• Web Development</li>
                                <li>• Artificial Intelligence</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                
                </div>
                <!-- Messages and Achievements Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Messages Section -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-6 border-b pb-2">
                            <h2 class="text-xl font-bold">Messages</h2>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="border rounded-md p-4 hover:bg-gray-50 cursor-pointer">
                                <div class="flex justify-between">
                                    <h3 class="font-semibold">Professor Smith</h3>
                                    <span class="text-sm text-gray-500">Today</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 truncate">Regarding your project submission - please check the feedback I've provided...</p>
                            </div>
                            
                            <div class="border rounded-md p-4 hover:bg-gray-50 cursor-pointer">
                                <div class="flex justify-between">
                                    <h3 class="font-semibold">Admissions Office</h3>
                                    <span class="text-sm text-gray-500">Yesterday</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 truncate">Important information about your scholarship application status...</p>
                            </div>
                            
                            <div class="border rounded-md p-4 hover:bg-gray-50 cursor-pointer">
                                <div class="flex justify-between">
                                    <h3 class="font-semibold">Student Affairs</h3>
                                    <span class="text-sm text-gray-500">2 days ago</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 truncate">Reminder: Upcoming career fair on campus next week...</p>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="#" class="text-primary hover:text-secondary text-sm font-medium">
                                    View All Messages
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Achievements Section -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-6 border-b pb-2">
                            <h2 class="text-xl font-bold">Achievements</h2>
                            <button class="px-3 py-1 bg-primary text-white rounded-md text-sm hover:bg-secondary transition">
                                <i class="fas fa-plus mr-1"></i> Add New
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach (\App\Models\Category::all() as $category)
                            <div class="border rounded-md p-4">
                                <div class="flex justify-between">
                                    <h3 class="font-semibold">{{ $category->name }}</h3>
                                    <span class="text-sm text-gray-500">Spring 2023</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Awarded for academic excellence</p>
                                <div class="mt-2 flex space-x-2">
                                    <button class="text-primary hover:text-secondary text-sm">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </button>
                                    <button class="text-primary hover:text-secondary text-sm">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </button>
                                </div>
                            </div>
                            @endforeach
                            <div class="text-center mt-4">
                                <a href="#" class="text-primary hover:text-secondary text-sm font-medium">
                                    View All Achievements
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>
    
    <footer class="bg-white border-t mt-8">
        <div class="container mx-auto px-4 py-6 text-center text-gray-600 text-sm">
            <p>© 20255 TTYSI University Student Portal</p>
        </div>
    </footer>
    
    <script>
        // Notification dropdown toggle
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
        
        // Sample data for messages
        const messages = [
        {
            id: 1,
            sender: "Professor Smith",
            preview: "Regarding your project submission - please check the feedback I've provided...",
            date: "Today",
            read: false
        },
        {
            id: 2,
            sender: "Admissions Office",
            preview: "Important information about your scholarship application status...",
            date: "Yesterday",
            read: false
        },
        {
            id: 3,
            sender: "Student Affairs",
            preview: "Reminder: Upcoming career fair on campus next week...",
            date: "2 days ago",
            read: true
        }
        ];
        
        // Sample data for achievements
        const achievements = [
        {
            id: 1,
            title: "Dean's List Certificate",
            description: "Awarded for academic excellence",
            date: "Spring 2023",
            type: "pdf",
            file: "deans-list.pdf"
        },
        {
            id: 2,
            title: "Hackathon Winner",
            description: "1st place in University Hackathon",
            date: "Fall 2022",
            type: "image",
            file: "hackathon.jpg"
        }
        ];
        
        // Navigation handling
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                console.log(`Navigating to: ${this.getAttribute('href')}`);
            });
        });
    </script>
</body>
</html>