<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'max_score'
    ];
    public function petitions()
    {
        return $this->hasMany(Petition::class);
    }
}
