<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class CategoryController extends Controller
{
    public function index()
    {
        // dd(Category::all());
        return view('category.index');
    }
    public function list()
    {
        return response()->json(Category::all());
    }

    // Store new category
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'max_score' => 'required|numeric'
        ]);
        $category = Category::create($data);
        return response()->json($category, 201);
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'max_score' => 'required|numeric'
        ]);
        $category->update($data);
        return response()->json($category);
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => true]);
    }
}
