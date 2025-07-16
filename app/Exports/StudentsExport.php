<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $auth = Auth::user();
        return User::where('type', 'student')->where('faculty', $auth->faculty)
        ->where(fn ($query) => 
            $query->whereHas('petitions')
        )
        ->get(['id', 'full_name','phone', 'passport_number', 'group_name']); 
    }
    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Phone',
            'Passport Number',
            'Group Name',
        ];
    }
}
