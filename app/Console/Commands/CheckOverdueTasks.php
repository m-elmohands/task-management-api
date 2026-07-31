<?php

namespace App\Console\Commands;

use App\Jobs\SendOverdueTaskNotification;
use App\Models\Task;
use Illuminate\Console\Command;

class CheckOverdueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue tasks and dispatch notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueTasks = Task::where('status', '!=', 'done')
            ->where('due_date', '<', now()->toDateString())
            ->whereNull('notified_at')
            ->get();

        foreach ($overdueTasks as $task) {
            SendOverdueTaskNotification::dispatch($task);
            $task->update(['notified_at' => now()]);
        }

        $this->info("{$overdueTasks->count()} overdue task(s) notified.");
    }
}
