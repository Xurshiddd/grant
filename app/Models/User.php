<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    
    /**
    * The attributes that are mass assignable.
    *
    * @var list<string>
    */
    protected $fillable = [
        'student_id_number',
'email',
'uuid',
'type',
'firstname',
'surname',
'father_name',
'image',
'full_name',
'birth_date',
'passport_pnfl',
'passport_number',
'education_form',
'education_type',
'livel',
'group_name',
'avg_gpa',
'address',
'country',
'phone',
        'password',
    ];
    
    /**
    * The attributes that should be hidden for serialization.
    *
    * @var list<string>
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function petitions()
    {
        return $this->hasMany(Petition::class);
    }
    public function audits()
    {
        return $this->hasMany(Audit::class, 'user_id');
    }
}
