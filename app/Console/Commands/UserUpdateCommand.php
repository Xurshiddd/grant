<?php

namespace App\Console\Commands;

use App\Models\StudentData;
use App\Models\User;
use Illuminate\Console\Command;

class UserUpdateCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'app:user-update';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Talaba malumotlarini yangilash';
    
    /**
    * Execute the console command.
    */
    public function handle()
    {
        $data = StudentData::all();
        foreach ($data as $item) {
            $user = User::where('id', $item->user_id)->first();
            if ($user) {
                $user->update([
                    'education_direction_code' => $item->data['specialty']['code'],
                    'is_rus' => $item->data['group']['educationLang'] == 'Rus' ? true : false,
                ]);
                $this->info("✅ Ma'lumot yangilandi: {$user->student_id_number}");
            }
        }
    }
}