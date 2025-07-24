<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AllStudentExcel implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('type', 'student')
        ->get(['full_name', 'group_name', 'avg_gpa']); 
    }
    public function headings(): array
    {
        return [
            'F.I.O',
            'Guruh nomi',
            'GPA'
        ];
    }
}
