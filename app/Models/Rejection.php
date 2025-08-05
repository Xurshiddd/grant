<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rejection extends Model
{
    protected $fillable = [
        'user_id',
        'reason'
    ];
}
