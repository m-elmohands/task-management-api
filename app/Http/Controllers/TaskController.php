<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    public function index(Request $request, int $projectId): JsonResponse
    {
        $tasks = $this->taskService->getProjectTasks(
            $projectId,
            $request->only(['status', 'priority', 'search'])
        );

        return apiResponse(
            TaskResource::collection($tasks),
        );
    }

    public function store(StoreTaskRequest $request, int $projectId): JsonResponse
    {
        $task = $this->taskService->createTask(
            $request->validated(),
            $projectId
        );

        return apiResponse(
            new TaskResource($task),
            'Task created successfully.',
            201
        );
    }

    public function show(int $projectId, int $taskId): JsonResponse
    {
        try {
            $task = $this->taskService->getTask($taskId, $projectId);
            return apiResponse(
                new TaskResource($task),
            );
        } catch (ModelNotFoundException $e) {
            return apiResponse(
                message: $e->getMessage(),
                status: 404
            );
        }
    }

    public function update(UpdateTaskRequest $request, int $projectId, int $taskId): JsonResponse
    {
        try {
            $task = $this->taskService->updateTask(
                $taskId,
                $request->validated(),
                $projectId
            );

            return apiResponse(
                new TaskResource($task),
                'Task updated successfully.',
            );
        } catch (ModelNotFoundException $e) {
            return apiResponse(
                message: $e->getMessage(),
                status: 404
            );
        }
    }

    public function destroy(int $projectId, int $taskId): JsonResponse
    {
        try {
            $this->taskService->deleteTask($taskId, $projectId);
            return apiResponse(
                message: 'Task deleted successfully.',
            );
        } catch (ModelNotFoundException $e) {
            return apiResponse(
                message: $e->getMessage(),
                status: 404
            );
        }
    }
}