<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    protected $fillable = [
        'user_id',
        'grant_type',
        'comment',
    ];
}
