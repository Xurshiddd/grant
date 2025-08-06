<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $fillable = [
        'name',
        'code',
        'faculty_code',
        'education_type',
    ];
}
