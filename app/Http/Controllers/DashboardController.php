<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petition;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Oylik userlar
        $monthlyUsers = User::where('type', 'user')
            ->selectRaw("strftime('%m', created_at) as month, COUNT(*) as count")
            ->groupBy('month')
            ->pluck('count', 'month');

        
        // Petitions kategoriyalarga ko‘ra
        $petitionsByCategory = Petition::select('category_id', DB::raw('count(*) as total'))
        ->groupBy('category_id')
        ->with('category') // agar relation mavjud bo‘lsa
        ->get();
        
        return view('dashboard', [
            'monthlyUsers' => $monthlyUsers,
            'petitionsByCategory' => $petitionsByCategory
        ]);
    }
}
