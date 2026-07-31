<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOverdueTaskNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Task $task) {}

    public function handle(): void
    {
        $user = $this->task->project->user;

        Log::info("Overdue task notification sent", [
            'task_id' => $this->task->id,
            'user_email' => $user->email,
        ]);

        // In production, send actual email:
        // Mail::to($user->email)->send(new TaskOverdueMail($this->task));
    }
}