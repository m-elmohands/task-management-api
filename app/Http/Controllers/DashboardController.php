<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $totalProjects = Project::where('user_id', $userId)->count();
        $activeProjects = Project::where('user_id', $userId)
            ->where('status', 'active')
            ->count();

        $projectIds = Project::where('user_id', $userId)->pluck('id');

        $totalTasks = Task::whereIn('project_id', $projectIds)->count();
        $completedTasks = Task::whereIn('project_id', $projectIds)
            ->where('status', 'done')
            ->count();
        $pendingTasks = Task::whereIn('project_id', $projectIds)
            ->where('status', '!=', 'done')
            ->count();
        $overdueTasks = Task::whereIn('project_id', $projectIds)
            ->where('status', '!=', 'done')
            ->where('due_date', '<', now()->toDateString())
            ->count();

        return apiResponse([
            'total_projects' => $totalProjects,
            'active_projects' => $activeProjects,
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'pending_tasks' => $pendingTasks,
            'overdue_tasks' => $overdueTasks,
        ]);
    }
}