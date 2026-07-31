<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\StoreProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectService $projectService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $projects = $this->projectService->getUserProjects(
            $request->user()->id,
            $request->only(['status'])
        );

        return apiResponse(
            ProjectResource::collection($projects),
        );
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->createProject(
            $request->validated(),
            $request->user()->id
        );

        return apiResponse(
            new ProjectResource($project),
            'Project created successfully.',
            201
        );
    }

    public function show(int $id, Request $request): JsonResponse
    {
        try {
            $project = $this->projectService->getProject($id, $request->user()->id);
            return apiResponse(
                new ProjectResource($project),
            );
        } catch (ModelNotFoundException $e) {
            return apiResponse(
                message: $e->getMessage(),
                status: 404
            );
        }
    }

    public function update(UpdateProjectRequest $request, int $id): JsonResponse
    {
        try {
            $project = $this->projectService->updateProject(
                $id,
                $request->validated(),
                $request->user()->id
            );

            return apiResponse(
                new ProjectResource($project),
                'Project updated successfully.',
            );
        } catch (ModelNotFoundException $e) {
            return apiResponse(
                message: $e->getMessage(),
                status: 404
            );
        }
    }

    public function destroy(int $id, Request $request): JsonResponse
    {
        try {
            $this->projectService->deleteProject($id, $request->user()->id);
            return apiResponse(
                'Project deleted successfully.',
            );
        } catch (ModelNotFoundException $e) {
            return apiResponse(
                message: $e->getMessage(),
                status: 404
            );
        }
    }
}