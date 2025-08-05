<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Rejection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RejectionController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'reason' => 'required|string',
        'student_id' => 'required|integer'
    ]);

    try {
        DB::beginTransaction();

        Rejection::create([
            'reason' => $request->reason,
            'user_id' => $request->student_id,
        ]);
        Message::create([
            'user_id' => $request->student_id,
            'subject' => 'Grant uchun ariza rad etildi',
            'body' => $request->reason
        ]);
        DB::commit();

        return redirect()->back()->with('success', 'Ariza rad etildi.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
    }
}
}
