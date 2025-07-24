<?php

namespace App\Http\Controllers;

use App\Models\Petition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessPetitionUpload;
use Carbon\Carbon;

class PetitionController extends Controller
{
    public function index()
    {
        // Bu yerda petitionlarni olish va ko'rsatish logikasini yozing
        return view('petitions.index');
    }
    
    public function create()
    {
        // Yangi petition yaratish formasi
        return view('petitions.create');
    }
    
    public function store(Request $request)
    {
        $now = Carbon::now();
        $deadline = Carbon::create($now->year, 7, 21);
        if ($now->greaterThan($deadline)) {
            return redirect()->route('welcome')->withErrors([
                'error' => "Ariza qabul qilish muddati tugagan."
            ]);
        }
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'path' => 'required|array',
            'path.*' => 'file|mimes:pdf,doc,docx,png,jpg,jpeg,webp|max:5120', // har bir fayl uchun 5MB
            
        ]);
        
        foreach ($request->file('path') as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/' . $filename;
            $file->move(public_path('uploads'), $filename);
            Petition::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'path' => $path,
                'evaluation' => 0, // default qiymat
            ]);
        }
        return redirect()->back()->with('success', 'Petition created successfully.');
    }
    
    public function show($id)
    {
        // Petitionni ko'rsatish logikasi
        return view('petitions.show', compact('id'));
    }
    
    public function edit($id)
    {
        // Petitionni tahrirlash formasi
        return view('petitions.edit', compact('id'));
    }
    
    public function update(Request $request, $id)
    {
        // Petitionni yangilash logikasi
        return redirect()->route('petitions.index')->with('success', 'Petition updated successfully.');
    }
    public function delete($id)
    {
        $now = Carbon::now();
        $deadline = Carbon::create($now->year, 7, 21);
        if ($now->greaterThan($deadline)) {
            return redirect()->route('welcome')->withErrors([
                'error' => "Ariza qabul qilish muddati tugagan."
            ]);
        }
       $petition = Petition::find($id);
    //    dd($petition);
        $petition->delete();
        // Faylni serverdan o'chirish
        if (file_exists(public_path($petition->path))) {
            unlink(public_path($petition->path));
        }
        return response()->json([
            'success' => true,
            'message' => 'Petition deleted successfully.',
        ]);
    }
    public function destroy($id)
    {
        // dd($id);
        // return redirect()->back()->with('success', 'Petition deleted successfully.');
    }
}
