<?php

namespace App\Console\Commands;

use App\Models\StudentData;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UserDataGet extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'app:user-data-get';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Talabani malumotlarini Hemisdan tortib kelish';
    
    /**
    * Execute the console command.
    */
    public function handle()
    {
        $token = env('HEMIS_TOKEN');
        $baseUrl = 'https://student.ttyesi.uz/rest/v1/data/student-list';
        $students = User::where('type', 'student')->pluck('student_id_number');
        $count = 0;
        foreach ($students as $student) {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                ])->get("{$baseUrl}?search={$student}");
                if ($response->successful()) {
                    $data = $response->json();
                    $item = $data['data']['items'][0] ?? null;
                    if ($item) {
                        $count++;
                        $user = User::where('student_id_number', $student)->first();
                        
                        if ($user) {
                            StudentData::updateOrInsert([
                                'user_id' => $user->id,
                            ], [
                                'data' => json_encode($item),
                            ]);
                            $this->info("✅ Ma'lumot saqlandi: {$student} -> count {$count}");
                        } else {
                            $this->warn("⚠️ User topilmadi: {$student}");
                        }
                    } else {
                        $this->warn("⚠️ Item mavjud emas: {$student}");
                    }
                    
                    // 🔁 So'rovlar oralig'iga delay qo'shish (rate limit uchun)
                    usleep(150000);
                }
            }
        }
    }