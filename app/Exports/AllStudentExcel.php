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
                'users.full_name',
                'users.passport_pnfl',
                'users.avg_gpa',
                DB::raw("ROUND(SUM(audits.new_values) / 5, 2) AS BALL")
            )
            ->where('users.type', 'student')
            ->groupBy('users.full_name', 'users.passport_pnfl', 'users.avg_gpa')
            ->orderBy('users.avg_gpa', 'asc')
            ->get();
        return $results;
    }
    public function headings(): array
    {
        return [
            'F.I.Sh',
            'PINFL',
            'GPA',
            'Ijtimoiy ball'
        ];
    }
}
