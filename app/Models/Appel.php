<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appel extends Model
{
    protected $fillable = [
        'user_id'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
