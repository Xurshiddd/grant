<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = [
        'user_id',
        'event',
        'category_id',
        'comment',
        'auditable_id',
        'old_values',
        'new_values',
    ];
}
