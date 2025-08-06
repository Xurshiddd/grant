<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Speciality;

class getSpeciality extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-speciality';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hemisdan specialitylarni olish';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = env('HEMIS_TOKEN');
        $baseUrl = 'https://student.ttyesi.uz/rest/v1/data/specialty-list';
        for ($i = 1; $i <= 4; $i++) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            ])->get("{$baseUrl}?page=1&limit=100&_department={$i}");
            if ($response->successful()) {
                $data = $response->json();
                $items = $data['data']['items'] ?? [];
                foreach ($items as $item) {
                    Speciality::firstOrCreate([
                        'code' => $item['code'],
                    ], [
                        'name' => $item['name'],
                        'faculty_code' => $item['department']['code'],
                        'education_type' => $item['educationType']['code'],
                    ]);
                }
            }
            $this->info("✅ Specialitylar saqlandi: {$i}");
            usleep(150000);
        }
    }
}
