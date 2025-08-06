<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentData extends Model
{
    protected $fillable = ['user_id', 'data'];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'data' => 'array',
    ];
}
