<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .progress-ring__circle {
            transition: stroke-dashoffset 0.5s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
        .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background-color: #ef4444;
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="gradient-bg text-white shadow-lg">
            <div class="container mx-auto px-4 py-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Profile Dashboard</h1>
                    <div class="relative">
                        <button id="notificationBtn" class="p-2 rounded-full hover:bg-purple-700 transition">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="notification-dot"></span>
                        </button>
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg z-10">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="font-semibold text-gray-800">Notifications (3)</h3>
                            </div>
                            <div class="divide-y divide-gray-200">
                                <a href="#" class="block px-4 py-3 hover:bg-gray-100">
                                    <p class="text-sm text-gray-700">New message from John</p>
                                    <p class="text-xs text-gray-500">2 minutes ago</p>
                                </a>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-100">
                                    <p class="text-sm text-gray-700">Your submission was approved</p>
                                    <p class="text-xs text-gray-500">1 hour ago</p>
                                </a>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-100">
                                    <p class="text-sm text-gray-700">New assignment posted</p>
                                    <p class="text-xs text-gray-500">3 hours ago</p>
                                </a>
                            </div>
                            <div class="p-2 text-center bg-gray-50">
                                <a href="#" class="text-sm text-purple-600 font-medium">View all notifications</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Sidebar -->
                <div class="w-full lg:w-1/3">
                    <!-- Profile Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition duration-300 card-hover">
                        <div class="gradient-bg h-32 relative">
                            <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                                <div class="h-32 w-32 rounded-full border-4 border-white overflow-hidden">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Profile" class="h-full w-full object-cover">
                                </div>
                            </div>
                        </div>
                        <div class="pt-20 pb-6 px-6">
                            <div class="text-center">
                                <h2 class="text-2xl font-bold text-gray-800">Sarah Johnson</h2>
                                <p class="text-gray-600">Computer Science Student</p>
                                <div class="flex justify-center mt-2">
                                    <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">Group A</span>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <p class="text-gray-500 text-sm">Courses</p>
                                    <p class="font-semibold">12</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Completed</p>
                                    <p class="font-semibold">8</p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Contact Info</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-envelope text-purple-600 mr-2"></i>
                                        <span class="text-gray-600">sarah.johnson@example.com</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-phone text-purple-600 mr-2"></i>
                                        <span class="text-gray-600">(555) 123-4567</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>
                                        <span class="text-gray-600">New York, USA</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Skills</h3>
                                <div class="space-y-2">
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>JavaScript</span>
                                            <span>85%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>Python</span>
                                            <span>75%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-purple-600 h-2 rounded-full" style="width: 75%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>Database</span>
                                            <span>65%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-purple-600 h-2 rounded-full" style="width: 65%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GPA and Score Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden mt-6 p-6 transition duration-300 card-hover">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Academic Performance</h3>
                        
                        <div class="flex items-center justify-between mb-6">
                            <div class="text-center">
                                <div class="relative w-24 h-24 mx-auto">
                                    <svg class="w-full h-full" viewBox="0 0 100 100">
                                        <circle class="text-gray-200" stroke-width="8" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" />
                                        <circle class="text-purple-600 progress-ring__circle" stroke-width="8" stroke-linecap="round" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" stroke-dasharray="251.2" stroke-dashoffset="calc(251.2 - (251.2 * 87) / 100)" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-2xl font-bold text-gray-800">87%</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">Overall Score</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="relative w-24 h-24 mx-auto">
                                    <svg class="w-full h-full" viewBox="0 0 100 100">
                                        <circle class="text-gray-200" stroke-width="8" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" />
                                        <circle class="text-green-500 progress-ring__circle" stroke-width="8" stroke-linecap="round" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" stroke-dasharray="251.2" stroke-dashoffset="calc(251.2 - (251.2 * 3.7) / 4)" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-2xl font-bold text-gray-800">3.7</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">GPA</p>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Assignments</span>
                                <span class="text-sm font-semibold text-purple-600">92%</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Exams</span>
                                <span class="text-sm font-semibold text-purple-600">85%</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Participation</span>
                                <span class="text-sm font-semibold text-purple-600">95%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="w-full lg:w-2/3">
                    <!-- Categories and Work Section -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition duration-300 card-hover">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-xl font-bold text-gray-800">My Work</h2>
                                <button id="uploadBtn" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                                    <i class="fas fa-plus mr-2"></i> Upload Work
                                </button>
                            </div>

                            <!-- Upload Modal (Hidden by default) -->
                            <div id="uploadModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold">Upload New Work</h3>
                                        <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <form id="uploadForm">
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-medium mb-2" for="category">
                                                Category
                                            </label>
                                            <select id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600">
                                                <option value="assignment">Assignment</option>
                                                <option value="project">Project</option>
                                                <option value="research">Research</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-medium mb-2" for="description">
                                                Description
                                            </label>
                                            <textarea id="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600"></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-medium mb-2" for="file">
                                                File
                                            </label>
                                            <div class="flex items-center justify-center w-full">
                                                <label for="file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                                        <p class="mb-2 text-sm text-gray-500">Click to upload or drag and drop</p>
                                                        <p class="text-xs text-gray-500">PDF, DOCX, PPTX (MAX. 10MB)</p>
                                                    </div>
                                                    <input id="file" type="file" class="hidden" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="button" id="cancelUpload" class="mr-2 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition">
                                                Cancel
                                            </button>
                                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">
                                                Upload
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Category Tabs -->
                            <div class="border-b border-gray-200">
                                <ul class="flex flex-wrap -mb-px" id="categoryTabs">
                                    <li class="mr-2">
                                        <button class="category-tab active inline-block p-4 text-purple-600 border-b-2 border-purple-600 rounded-t-lg" data-category="all">All</button>
                                    </li>
                                    <li class="mr-2">
                                        <button class="category-tab inline-block p-4 text-gray-500 hover:text-gray-600 hover:border-gray-300 border-b-2 border-transparent rounded-t-lg" data-category="assignment">Assignments</button>
                                    </li>
                                    <li class="mr-2">
                                        <button class="category-tab inline-block p-4 text-gray-500 hover:text-gray-600 hover:border-gray-300 border-b-2 border-transparent rounded-t-lg" data-category="project">Projects</button>
                                    </li>
                                    <li class="mr-2">
                                        <button class="category-tab inline-block p-4 text-gray-500 hover:text-gray-600 hover:border-gray-300 border-b-2 border-transparent rounded-t-lg" data-category="research">Research</button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Work Items -->
                            <div id="workItems" class="mt-6 space-y-4">
                                <!-- Work Item 1 -->
                                <div class="work-item p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition" data-category="assignment">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-purple-100 p-3 rounded-lg">
                                            <i class="fas fa-file-alt text-purple-600 text-xl"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between">
                                                <h3 class="font-medium text-gray-900">Data Structures Assignment</h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Assignment</span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">Implementation of various sorting algorithms with performance analysis.</p>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                <span>Submitted on May 15, 2023</span>
                                            </div>
                                            <div class="mt-2 flex items-center">
                                                <span class="text-sm font-medium text-gray-900 mr-2">Grade:</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">A (95%)</span>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <button class="p-2 text-gray-400 hover:text-gray-500">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Work Item 2 -->
                                <div class="work-item p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition" data-category="project">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg">
                                            <i class="fas fa-project-diagram text-blue-600 text-xl"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between">
                                                <h3 class="font-medium text-gray-900">E-commerce Website</h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Project</span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">Full-stack e-commerce platform with React frontend and Node.js backend.</p>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                <span>Submitted on April 28, 2023</span>
                                            </div>
                                            <div class="mt-2 flex items-center">
                                                <span class="text-sm font-medium text-gray-900 mr-2">Grade:</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">A+ (98%)</span>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <button class="p-2 text-gray-400 hover:text-gray-500">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Work Item 3 -->
                                <div class="work-item p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition" data-category="research">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-lg">
                                            <i class="fas fa-microscope text-yellow-600 text-xl"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between">
                                                <h3 class="font-medium text-gray-900">AI in Healthcare Research</h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Research</span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">Analysis of machine learning applications in medical diagnosis systems.</p>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                <span>Submitted on March 10, 2023</span>
                                            </div>
                                            <div class="mt-2 flex items-center">
                                                <span class="text-sm font-medium text-gray-900 mr-2">Grade:</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">A (93%)</span>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <button class="p-2 text-gray-400 hover:text-gray-500">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Work Item 4 -->
                                <div class="work-item p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition" data-category="assignment">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-purple-100 p-3 rounded-lg">
                                            <i class="fas fa-file-alt text-purple-600 text-xl"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between">
                                                <h3 class="font-medium text-gray-900">Database Design</h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Assignment</span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">ER diagrams and SQL queries for library management system.</p>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                <span>Submitted on February 22, 2023</span>
                                            </div>
                                            <div class="mt-2 flex items-center">
                                                <span class="text-sm font-medium text-gray-900 mr-2">Grade:</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">A- (90%)</span>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <button class="p-2 text-gray-400 hover:text-gray-500">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden mt-6 transition duration-300 card-hover">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-6">Recent Activity</h2>
                            
                            <div class="space-y-4">
                                <!-- Activity Item 1 -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-purple-100 p-2 rounded-full">
                                        <i class="fas fa-check-circle text-purple-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Assignment graded</p>
                                        <p class="text-sm text-gray-600">Your "Data Structures Assignment" received 95%</p>
                                        <p class="text-xs text-gray-500 mt-1">2 days ago</p>
                                    </div>
                                </div>
                                
                                <!-- Activity Item 2 -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-blue-100 p-2 rounded-full">
                                        <i class="fas fa-comment-alt text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">New feedback</p>
                                        <p class="text-sm text-gray-600">Professor Smith left comments on your research paper</p>
                                        <p class="text-xs text-gray-500 mt-1">1 week ago</p>
                                    </div>
                                </div>
                                
                                <!-- Activity Item 3 -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
                                        <i class="fas fa-upload text-green-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Work submitted</p>
                                        <p class="text-sm text-gray-600">You uploaded "E-commerce Website Project"</p>
                                        <p class="text-xs text-gray-500 mt-1">2 weeks ago</p>
                                    </div>
                                </div>
                                
                                <!-- Activity Item 4 -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-yellow-100 p-2 rounded-full">
                                        <i class="fas fa-award text-yellow-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Achievement unlocked</p>
                                        <p class="text-sm text-gray-600">You earned the "Top Performer" badge for this semester</p>
                                        <p class="text-xs text-gray-500 mt-1">3 weeks ago</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 text-center">
                                <a href="#" class="text-sm font-medium text-purple-600 hover:text-purple-700">View all activity</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Notification dropdown toggle
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        
        notificationBtn.addEventListener('click', () => {
            notificationDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });
        
        // Upload modal functionality
        const uploadBtn = document.getElementById('uploadBtn');
        const uploadModal = document.getElementById('uploadModal');
        const closeModal = document.getElementById('closeModal');
        const cancelUpload = document.getElementById('cancelUpload');
        
        uploadBtn.addEventListener('click', () => {
            uploadModal.classList.remove('hidden');
        });
        
        closeModal.addEventListener('click', () => {
            uploadModal.classList.add('hidden');
        });
        
        cancelUpload.addEventListener('click', () => {
            uploadModal.classList.add('hidden');
        });
        
        // Close modal when clicking outside
        uploadModal.addEventListener('click', (e) => {
            if (e.target === uploadModal) {
                uploadModal.classList.add('hidden');
            }
        });
        
        // Form submission
        const uploadForm = document.getElementById('uploadForm');
        uploadForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Here you would typically handle the file upload with AJAX
            alert('Work uploaded successfully!');
            uploadModal.classList.add('hidden');
            uploadForm.reset();
        });
        
        // Category tabs functionality
        const categoryTabs = document.querySelectorAll('.category-tab');
        const workItems = document.querySelectorAll('.work-item');
        
        categoryTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Update active tab
                categoryTabs.forEach(t => t.classList.remove('active', 'text-purple-600', 'border-purple-600'));
                categoryTabs.forEach(t => t.classList.add('text-gray-500', 'hover:text-gray-600', 'hover:border-gray-300', 'border-transparent'));
                
                tab.classList.add('active', 'text-purple-600', 'border-purple-600');
                tab.classList.remove('text-gray-500', 'hover:text-gray-600', 'hover:border-gray-300', 'border-transparent');
                
                // Filter work items
                const category = tab.getAttribute('data-category');
                
                workItems.forEach(item => {
                    if (category === 'all' || item.getAttribute('data-category') === category) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });
        });
    </script>
</body>
</html>