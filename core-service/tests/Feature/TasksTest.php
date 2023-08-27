<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TasksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * should success when auth user get tasks
     */
    public function test_get_task_should_success(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/api/task');
        $response->assertStatus(200);
    }
    /**
     * should not success when not auth user get tasks
     */
    public function test_get_task_should_not_success(): void
    {
        $response = $this->get('/api/task');
        $response->assertStatus(401);
    }
    /**
     * should not success when creating a task with no name
     */
    public function test_create_task_no_name(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/api/task', ['description' => 'test']);
        $response->assertStatus(400);
    }
    /**
     * should not success when creating a task with no description
     */
    public function test_create_task_no_description(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/api/task', ['name' => 'test']);
        $response->assertStatus(400);
    }
    /**
     * should success when creating a task with valid body
     */
    public function test_create_task_with_correct_body(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/api/task', ['name' => 'test', 'description' => 'test']);
        $response->assertStatus(200);
    }
    /**
     * should not success when updating other user task
     */
    public function test_update_other_user_task(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $task = Task::factory()->create([
            'name' => 'test',
            'description' => 'test',
            'user_id' => $user2 ->id,
        ]);
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->patch('/api/task/'.$task->id, ['name' => 'test', 'description' => 'test']);
        $response->assertStatus(401);
    }
    /**
     * should success when updating own user task
     */
    public function test_update_own_user_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'name' => 'test',
            'description' => 'test',
            'user_id' => $user ->id,
        ]);
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->patch('/api/task/'.$task->id, ['name' => 'test', 'description' => 'test']);
        $response->assertStatus(200);
    }
    /**
     * should not success when deleting other user task
     */
    public function test_delete_other_user_task(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $task = Task::factory()->create([
            'name' => 'test',
            'description' => 'test',
            'user_id' => $user2 ->id,
        ]);
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/api/task/'.$task->id);
        $response->assertStatus(401);
    }
    /**
     * should success when deleting own user task
     */
    public function test_delete_own_user_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'name' => 'test',
            'description' => 'test',
            'user_id' => $user ->id,
        ]);
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/api/task/'.$task->id);
        $response->assertStatus(200);
    }
}
