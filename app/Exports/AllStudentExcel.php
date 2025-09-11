<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AllStudentExcel implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $results = DB::table('users')
            ->join('audits', 'users.id', '=', 'audits.user_id')
            ->leftJoin('specialities', 'users.education_direction_code', '=', 'specialities.code')
            ->select(
                DB::raw("CONCAT(specialities.code, '-', specialities.name, '2024-2025') AS speciality"),
                'users.group_name',
                'users.full_name',
                'users.passport_pnfl',
                'users.avg_gpa',
                DB::raw("ROUND(SUM(audits.new_values) / 5, 2) AS BALL")
            )
            ->where('users.type', 'student')
            ->groupBy('speciality', 'users.full_name', 'users.group_name', 'users.education_direction_code', 'users.passport_pnfl', 'users.avg_gpa',)
            ->orderBy('speciality', 'asc')
            ->get();
        return $results;
    }
    public function headings(): array
    {
        return [
            'Mutaxasislik',
            'Guruh nomi',
            'F.I.Sh',
            'PNFL',
            'GPA',
            'Ball',
        ];
    }
}
