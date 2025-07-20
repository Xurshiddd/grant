<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UserUpdateJob;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DekanCreateCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'app:update';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Dekan User qo\'shildi';
    
    /**
    * Execute the console command.
    */
    public function handle()
    {
        DB::transaction(function () {
            
            // 1) Dekanlarni tozalaymiz
            User::where('type', 'dekan')->delete();
            
            // 2) Dekanlar ro‘yxati
            $deans = [
                [
                    'uuid'              => Str::uuid(),
                    'student_id_number' => '1234986919',
                    'email'             => 'm.mansurov@ttysi.uz',
                    'firstname'         => 'Mansur',
                    'surname'           => 'Mansurov',
                    'father_name'       => 'Alisherovich',
                    'full_name'         => 'Mansurov Mansur Alisherovich',
                    'faculty'           => '331-304',
                ],
                [
                    'uuid'              => Str::uuid(),
                    'student_id_number' => '1234986978',
                    'email'             => 's.patxullayev@ttysi.uz',
                    'firstname'         => 'Sarvarjon',
                    'surname'           => 'Patxullayev',
                    'father_name'       => 'Ubaydulla o\'gli',
                    'full_name'         => 'Patxullayev Sarvarjon Ubaydulla o\'gli',
                    'faculty'           => '331-302',
                ],
                [
                    'uuid'              => Str::uuid(),
                    'student_id_number' => '1234985229',
                    'email'             => 'm.ruzmetov@ttysi.uz',
                    'firstname'         => 'Mansurbek',
                    'surname'           => 'Ruzmetov',
                    'father_name'       => 'Erkinovich',
                    'full_name'         => 'Ruzmetov Mansurbek Erkinovich',
                    'faculty'           => '331-301',
                ],
                [
                    'uuid'              => Str::uuid(),
                    'student_id_number' => '1234936985',
                    'email'             => 'a.toshev@ttysi.uz',
                    'firstname'         => 'Akmal',
                    'surname'           => 'Toshev',
                    'father_name'       => 'Yusupovich',
                    'full_name'         => 'Toshev Akmal Yusupovich',
                    'faculty'           => '331-303',
                ],
                
            ];
            
            foreach ($deans as $dean) {
                User::create(array_merge($dean, [
                    'type'     => 'dekan',
                    'password' => Hash::make('dekan123'),
                ]));
            }
        });
        
        $this->info('Dekanlar qo‘shildi');
        
        // 3) Fakultet → guruhlar map’i
        $data = [
            '331-301' => ['29-24', '22-24', '22a-24', '3-24', '3a-24', '31-24', '24-24', '24a-24', '2-24', '1-24', 'M22-24', 'M3-24', 'M27-24', 'M1-24', 'M24-24', 'M2-24'],
            '331-302' => ['4-24','5-24','6-24','7-24','8-24','8r-24','9-24','16-24','16r-24','28-24','M23-24','M9-24','M7-24','M4-24','M5-24','M8-24','M16-24', 'M17-24'],
            '331-303' => ['10-24', '10r-24', '12-20-24', '18-24', '25-24', '25a-24', '25b-24', '25r-24', '27-24', '30-24', '35-24', 'M25-24', 'M10-11-24', 'M12-20-24', 'M30-24'],
            '331-304' => ['13-24','13a-24','13b-24','13v-24','13r-24','14-24','14a-24','14b-24','14v-24','14r-24','19-24','19a-24','19b-24','19v-24','19r-24','32-24','33-24','34-24','M13-24','M14-24'],
        ];
        
        foreach ($data as $faculty => $groups) {
            if (!empty($groups)) {
                User::whereIn('group_name', $groups)
                ->update(['faculty' => $faculty]);
            }
            $this->info($faculty . 'fakultet qo\'shildi');
        }
    }
}
