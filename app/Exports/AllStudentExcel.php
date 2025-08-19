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
                DB::raw("CONCAT(specialities.code, '-', specialities.name) AS speciality"),
                'users.full_name',
                DB::raw("ROUND(SUM(audits.new_values) / 5, 2) AS BALL")
            )
            ->where('users.type', 'student')
            ->groupBy('speciality', 'users.full_name')
            ->orderBy('users.education_direction_code')
            ->get();
        return $results;
    }
    public function headings(): array
    {
        return [
            'Fakultet',
            'F.I.O',
            'Guruh nomi',
            'Ball'
        ];
    }
}
