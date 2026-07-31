<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskService
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function getProjectTasks(int $projectId, array $filters = []): LengthAwarePaginator
    {
        return $this->taskRepository->allForProject($projectId, $filters);
    }

    public function getTask(int $id, int $projectId): Task
    {
        $task = $this->taskRepository->findForProject($id, $projectId);

        if (!$task) {
            throw new ModelNotFoundException('Task not found.');
        }

        return $task;
    }

    public function createTask(array $data, int $projectId): Task
    {
        $data['project_id'] = $projectId;
        return $this->taskRepository->create($data);
    }

    public function updateTask(int $id, array $data, int $projectId): Task
    {
        $task = $this->getTask($id, $projectId);
        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask(int $id, int $projectId): bool
    {
        $task = $this->getTask($id, $projectId);
        return $this->taskRepository->delete($task);
    }
}