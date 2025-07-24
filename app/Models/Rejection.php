<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rejection extends Model
{
    protected $fillable = [
        'user_id',
        'faculity_code',
        'faculity_name',
        'education_direction_code',
        'education_direction_name',
        'is_rus'
    ];
}
