<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Audit;
use App\Models\Message;
use Illuminate\Console\Command;

class ScoreUpdate extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'app:score-update';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Ball qo\'yish';
    
    /**
    * Execute the console command.
    */
    public function handle()
    {
        $students = User::where('type', 'student')->get();
        
        foreach ($students as $student) {
            $gpa = round($student->avg_gpa, 1);
            $score = $this->gpaToScore($gpa);
            
            // Audit logga yozish
            // Audit::create([
            //     'user_id' => $student->id,
            //     'event' => 'Baholash',
            //     'category_id' => 13,
            //     'comment' => "Talabaning GPA ko‘rsatkichi: $gpa",
            //     'auditable_id' => 1,
            //     'old_values' => '0',
            //     'new_values' => $score,
            // ]);
            Message::create([
                'user_id' => $student->id,
                'subject' => 'Baholash',
                'body' => "Sizga 'Talabaning akademik oʻzlashtirishi' mezoni bo'yicha {$score} ball berildi.",
                'is_read' => false,
            ]);
            $this->info("{$student->full_name} - GPA: $gpa, Score: $score");
        }
        
        return Command::SUCCESS;
    }
    private function gpaToScore($gpa)
    {
        $map = [
            5.0 => 10.0,
            4.9 => 9.7,
            4.8 => 9.3,
            4.7 => 9.0,
            4.6 => 8.7,
            4.5 => 8.3,
            4.4 => 8.0,
            4.3 => 7.7,
            4.2 => 7.3,
            4.1 => 7.0,
            4.0 => 6.7,
            3.9 => 6.3,
            3.8 => 6.0,
            3.7 => 5.7,
            3.6 => 5.3,
            3.5 => 5.0,
        ];
        
        return $map[$gpa] ?? 0;
    }
}
