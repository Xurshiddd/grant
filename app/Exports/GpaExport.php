<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GpaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $facultyNames = [
        '331-101' => 'Sanoat texnologiyalari va mexanika fakulteti',
        '331-102' => 'To‘qimachilik muhandisligi fakulteti',
        '331-103' => 'Dizayn va texnologiyalar fakulteti',
        '331-104' => 'Iqtisodiyot fakulteti',
    ];

    $students = User::where('type', 'student')
        ->whereIn('faculty', array_keys($facultyNames))
        ->orderByRaw("FIELD(faculty, '331-101', '331-102', '331-103', '331-104')")
        ->get();
// dd($students);
    // Kerakli formatga o‘zgartiramiz
    return $students->map(function ($user) use ($facultyNames) {
        return [
            'faculty' => $facultyNames[$user->faculty] ?? $user->faculty,
            'full_name' => $user->full_name,
            'group_name' => $user->group_name,
            'avg_gpa' => (float)$user->avg_gpa * 16,
        ];
    });
    }
    public function headings(): array
    {
        return [
            'Fakultet',
            'F.I.Sh.',
            'Guruh nomi',
            'Ball'
        ];
    }
}
