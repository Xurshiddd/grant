@extends('layouts.admin')
@section('content')
<div class="container">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #6b73ff 0%, #000dff 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .input-highlight {
            transition: all 0.3s ease;
            border-color: #e2e8f0;
        }
        .input-highlight:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
    </style>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-layer-group mr-3 text-indigo-600"></i>
                Category Management
            </h1>
            <p class="text-gray-600 mt-2">Create and manage assessment categories with maximum scores</p>
        </header>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Create Category Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl p-6 card-shadow fade-in">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-plus-circle mr-2 text-indigo-500"></i>
                        Add New Category
                    </h2>
                    
                    <form id="categoryForm" class="space-y-4">
                        <div>
                            <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                            type="text" 
                            id="categoryName" 
                            required
                            class="w-full px-4 py-2 rounded-lg border input-highlight focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            placeholder="e.g. Homework, Exam, Project">
                        </div>
                        
                        <div>
                            <label for="maxScore" class="block text-sm font-medium text-gray-700 mb-1">
                                Maximum Score <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                type="number" 
                                id="maxScore" 
                                step="0.01"
                                min="0"
                                required
                                class="w-full px-4 py-2 rounded-lg border input-highlight focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                placeholder="e.g. 100.00">
                                <span class="absolute right-3 top-2 text-gray-500">pts</span>
                            </div>
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" class="w-full gradient-bg text-white py-2 px-4 rounded-lg hover:opacity-90 transition duration-200 flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>
                                Save Category
                            </button>
                        </div>
                    </form>
                </div>
                
                
                
            </div>
            
            <!-- Categories Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl overflow-hidden card-shadow fade-in">
                    <div class="px-6 py-4 border-b flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-table mr-2 text-indigo-500"></i>
                            All Categories
                        </h2>
                        <div class="relative">
                            <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Search categories..." 
                            class="px-4 py-2 rounded-lg border input-highlight focus:outline-none focus:ring-1 focus:ring-indigo-500 text-sm"
                            >
                            <i class="fas fa-search absolute right-3 top-2.5 text-gray-400 text-sm"></i>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Max Score
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="categoryTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Table rows will be added dynamically -->
                                <tr id="emptyState">
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                        <p>No categories added yet</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="px-6 py-4 border-t flex items-center justify-between bg-gray-50">
                        <div class="text-sm text-gray-500">
                            Showing <span id="showingCount">0</span> of <span id="totalCount">0</span> categories
                        </div>
                        <div class="flex space-x-2">
                            <button id="prevBtn" disabled class="px-3 py-1 rounded border bg-white text-gray-700 disabled:opacity-50">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button id="nextBtn" disabled class="px-3 py-1 rounded border bg-white text-gray-700 disabled:opacity-50">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 w-full max-w-md fade-in">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-edit mr-2 text-indigo-500"></i>
                    Edit Category
                </h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="editForm" class="space-y-4">
                <input type="hidden" id="editId">
                <div>
                    <label for="editName" class="block text-sm font-medium text-gray-700 mb-1">
                        Category Name
                    </label>
                    <input 
                    type="text" 
                    id="editName" 
                    required
                    class="w-full px-4 py-2 rounded-lg border input-highlight focus:outline-none focus:ring-1 focus:ring-indigo-500">
                </div>
                
                <div>
                    <label for="editMaxScore" class="block text-sm font-medium text-gray-700 mb-1">
                        Maximum Score
                    </label>
                    <div class="relative">
                        <input 
                        type="number" 
                        id="editMaxScore" 
                        step="0.01"
                        min="0"
                        required
                        class="w-full px-4 py-2 rounded-lg border input-highlight focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <span class="absolute right-3 top-2 text-gray-500">pts</span>
                    </div>
                </div>
                
                <div class="pt-2 flex justify-end space-x-3">
                    <button type="button" id="cancelEdit" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="gradient-bg text-white py-2 px-4 rounded-lg hover:opacity-90 transition duration-200">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 w-full max-w-md fade-in">
            <div class="text-center">
                <i class="fas fa-exclamation-triangle text-4xl text-yellow-500 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Confirm Deletion</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this category? This action cannot be undone.</p>
                
                <div class="flex justify-center space-x-4">
                    <button id="cancelDelete" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button id="confirmDelete" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-200">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        let categories = [];
        let filteredCategories = [];
        let currentEditId = null;
        let currentDeleteId = null;
        let currentPage = 1;
        const itemsPerPage = 5;

        // DOM Elements
        const categoryForm = document.getElementById('categoryForm');
        const categoryTableBody = document.getElementById('categoryTableBody');
        const emptyState = document.getElementById('emptyState');
        const editModal = document.getElementById('editModal');
        const closeModal = document.getElementById('closeModal');
        const cancelEdit = document.getElementById('cancelEdit');
        const editForm = document.getElementById('editForm');
        const confirmModal = document.getElementById('confirmModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        const searchInput = document.getElementById('searchInput');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const showingCount = document.getElementById('showingCount');
        const totalCount = document.getElementById('totalCount');

        // Fetch categories from backend
        async function fetchCategories() {
            const res = await fetch('/categories/list');
            categories = await res.json();
            filteredCategories = categories;
        }

        // Save new category to backend
        async function saveCategory(name, maxScore) {
            const res = await fetch('/categories', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, max_score: maxScore })
            });
            return await res.json();
        }

        // Update category in backend
        async function updateCategory(id, name, maxScore) {
            const res = await fetch(`/categories/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, max_score: maxScore })
            });
            return await res.json();
        }

        // Delete category in backend
        async function deleteCategory(id) {
            await fetch(`/categories/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        }

        // Render categories table
        function renderCategories() {
            // Filter by search
            const search = searchInput.value.trim().toLowerCase();
            filteredCategories = categories.filter(cat =>
                cat.name.toLowerCase().includes(search)
            );

            // Pagination
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageItems = filteredCategories.slice(start, end);

            // Clear table
            categoryTableBody.innerHTML = '';

            if (pageItems.length === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
                pageItems.forEach(cat => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-6 py-4">${cat.id}</td>
                        <td class="px-6 py-4">${cat.name}</td>
                        <td class="px-6 py-4">${cat.max_score}</td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-indigo-600 hover:text-indigo-900 mr-2" onclick="openEditModal(${cat.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-900" onclick="openDeleteModal(${cat.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    categoryTableBody.appendChild(tr);
                });
            }

            // Update pagination
            showingCount.textContent = pageItems.length;
            totalCount.textContent = filteredCategories.length;
            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = end >= filteredCategories.length;
        }

        // Update stats (if you have stats elements)
        function updateStats() {
            // Example: update totalCategoriesEl, avgScoreEl, highestScoreEl if present
        }

        // Open edit modal
        window.openEditModal = async function(id) {
            const cat = categories.find(c => c.id === id);
            if (!cat) return;
            currentEditId = id;
            document.getElementById('editId').value = id;
            document.getElementById('editName').value = cat.name;
            document.getElementById('editMaxScore').value = cat.max_score;
            editModal.classList.remove('hidden');
        };

        // Open delete modal
        window.openDeleteModal = function(id) {
            currentDeleteId = id;
            confirmModal.classList.remove('hidden');
        };

        // Close modals
        closeModal.addEventListener('click', () => editModal.classList.add('hidden'));
        cancelEdit.addEventListener('click', () => editModal.classList.add('hidden'));
        cancelDelete.addEventListener('click', () => confirmModal.classList.add('hidden'));

        // Pagination
        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderCategories();
            }
        });
        nextBtn.addEventListener('click', () => {
            if ((currentPage * itemsPerPage) < filteredCategories.length) {
                currentPage++;
                renderCategories();
            }
        });

        // Search
        searchInput.addEventListener('input', () => {
            currentPage = 1;
            renderCategories();
        });

        // Form submit
        categoryForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const name = document.getElementById('categoryName').value.trim();
            const maxScore = parseFloat(document.getElementById('maxScore').value);

            if (!name || isNaN(maxScore) || maxScore <= 0) {
                alert('Please enter valid category name and maximum score');
                return;
            }

            await saveCategory(name, maxScore);
            categoryForm.reset();
            currentPage = 1;
            await fetchCategories();
            renderCategories();
            updateStats();
        });

        // Edit form submit
        editForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const name = document.getElementById('editName').value.trim();
            const maxScore = parseFloat(document.getElementById('editMaxScore').value);

            if (!name || isNaN(maxScore) || maxScore <= 0) {
                alert('Please enter valid category name and maximum score');
                return;
            }

            await updateCategory(currentEditId, name, maxScore);
            editModal.classList.add('hidden');
            await fetchCategories();
            renderCategories();
            updateStats();
        });

        // Confirm delete
        confirmDelete.addEventListener('click', async function() {
            await deleteCategory(currentDeleteId);
            confirmModal.classList.add('hidden');
            await fetchCategories();
            renderCategories();
            updateStats();
        });

        // Init
        async function init() {
            await fetchCategories();
            renderCategories();
            updateStats();
        }
        document.addEventListener('DOMContentLoaded', init);
    </script>
</div>
@endsection