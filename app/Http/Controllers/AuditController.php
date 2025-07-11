<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audit;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'score' => 'required|numeric|min:0',
            'category' => 'nullable|exists:categories,id',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        try {
            $audit = Audit::where('user_id', $request->user_id)
            ->where('category_id', $request->category)
            ->first();
            
            if ($audit) {
                $audit->update([
                    'event' => 'Baholash yangilandi',
                    'comment' => $request->comment,
                    'auditable_id' => Auth::id(),
                    'old_values' => $audit->new_values,
                    'new_values' => $request->score,
                ]);
                
                return response()->json(['success' => 'Audit updated successfully'], 201);
            }
            
            Audit::create([
                'user_id' => $request->user_id,
                'event' => 'Baholash',
                'category_id' => $request->category,
                'comment' => $request->comment,
                'auditable_id' => Auth::id(),
                'old_values' => '0',
                'new_values' => $request->score,
            ]);
            
            return response()->json(['success' => 'Audit created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to process audit: ' . $e->getMessage()], 500);
        }
    }
    
}
