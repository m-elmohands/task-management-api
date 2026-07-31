<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectService
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository
    ) {}

    public function getUserProjects(int $userId, array $filters = []): LengthAwarePaginator
    {
        return $this->projectRepository->allForUser($userId, $filters);
    }

    public function getProject(int $id, int $userId): Project
    {
        $project = $this->projectRepository->findForUser($id, $userId);

        if (!$project) {
            throw new ModelNotFoundException('Project not found.');
        }

        return $project;
    }

    public function createProject(array $data, int $userId): Project
    {
        $data['user_id'] = $userId;
        return $this->projectRepository->create($data);
    }

    public function updateProject(int $id, array $data, int $userId): Project
    {
        $project = $this->getProject($id, $userId);
        return $this->projectRepository->update($project, $data);
    }

    public function deleteProject(int $id, int $userId): bool
    {
        $project = $this->getProject($id, $userId);
        return $this->projectRepository->delete($project);
    }
}