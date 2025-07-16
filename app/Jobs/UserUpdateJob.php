<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UserUpdateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    public function __construct(protected array $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $faculty => $groups) {
            if (!empty($groups)) {
                User::whereIn('group_name', $groups)
                    ->update(['faculty' => $faculty]);
            }
        }
    }
}
