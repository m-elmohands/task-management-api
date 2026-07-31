<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test')->plainTextToken;
    }

    public function test_user_can_list_projects(): void
    {
        Project::factory(3)->create(['user_id' => $this->user->id]);

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->getJson('/api/projects');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_user_can_create_project(): void
    {
        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->postJson('/api/projects', [
                'name' => 'New Project',
                'description' => 'Project description',
                'status' => 'active',
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'New Project'
            ]);
    }

    public function test_user_can_update_project(): void
    {
        $project = Project::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->putJson("/api/projects/{$project->id}", [
                'name' => 'Updated Name',
                'status' => 'completed',
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Updated Name'
            ]);
    }

    public function test_user_can_delete_project(): void
    {
        $project = Project::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->deleteJson("/api/projects/{$project->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted($project);
    }
}