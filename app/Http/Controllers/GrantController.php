<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Grant;
use App\Models\Message;
class GrantController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'faculty' => 'nullable|in:331-101,331-102,331-103,331-104',
            'speciality' => 'nullable|string|max:255'
        ]);
        // studentlarni audit ga join qilish kerak va ballarini hisoblab orderby qilish kerak
        $students = DB::table('users')
    ->join('audits', 'users.id', 'audits.user_id')
    ->leftJoin('grants', 'users.id', 'grants.user_id')
    ->where('users.type', 'student')
    ->when(isset($validated['faculty']), function ($q) use ($validated) {
        return $q->where('users.faculty', $validated['faculty']);
    })
    ->when(isset($validated['speciality']), function ($q) use ($validated) {
        return $q->where('users.education_direction_code', $validated['speciality']);
    })
    ->select(
        'users.id',
        'users.full_name', 
        'users.phone',
        'users.image',
        'users.student_id_number',
        'users.passport_number',
        'users.education_form',
        'users.education_type',
        'users.group_name',
        'grants.id as grant_id',
        'grants.grant_type',
        DB::raw('(SUM(audits.new_values)/5 + (users.avg_gpa * 16)) as total_score')
    )
    ->groupBy('users.id','grants.id','grants.grant_type')  // asosiy guruhlash
    ->orderBy('total_score', 'desc')
    ->paginate(10);
    $faculty = $validated['faculty'] ?? null;
    $speciality = $validated['speciality'] ?? null;
     
        return view('grant.index', compact('students', 'faculty', 'speciality'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'grant_type' => 'required|in:1,2',
            'comment' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            Grant::updateOrCreate([
                'user_id' => $validated['student_id'],
            ], [
                'grant_type' => $validated['grant_type'],
                'comment' => $validated['comment'],
            ]);
            $text = $validated['grant_type'] == 1 ? 'To\'liq grant' : 'To\'liq bo\'lmagan grant';
            Message::create([
                'user_id' => $validated['student_id'],
                'subject' => 'Grant!',
                'body' => 'Sizga '.$text.' berildi!',
                'is_read' => 0,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to add grant: ' . $th->getMessage()], 500);
        }
        return response()->json(['success' => 'Grant successfully added!'], 200);
    }
}
