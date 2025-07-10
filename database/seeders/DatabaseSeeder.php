<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::create([
            'uuid' => '123e4567-e89b-12d3-a456-426614174000',
            'student_id_number' => '1234567890',
            'type' => 'admin', // 'student', 'teacher', 'admin'
            'firstname' => 'Admin',
            'surname' => 'Doe',
            'father_name' => 'Smith',
            'full_name' => 'John Smith Doe',
            'phone' => '+998901234567',
            'passport_pnfl' => '1234567890123456',
            'passport_number' => 'AA1234567',
            'birth_date' => '2000-01-01',
            'group_name' => 'Group A',
            'education_form' => 'Full-time',
            'education_type' => 'Bachelor',
            'avg_gpa' => 3.8,
            'image' => null,
            'address' => '123 Main St, Tashkent, Uzbekistan',
            'email' => 'hemisadmin@gmail.com',
            'country' => 'Uzbekistan',
            'password' => bcrypt('admin123'),
        ]);
    }
}
