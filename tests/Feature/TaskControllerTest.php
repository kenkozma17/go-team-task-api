<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Status;

class TaskControllerTest extends TestCase
{
    /**
     * Test if index route returns 200 for authenticated users
     */
    public function test_index_returns_200_for_authenticated_users(): void {
      $user = User::factory()->create();
      $response = $this->actingAs($user)->get('api/statuses');

      $response->assertStatus(200);
    }

    /**
     * Test if index route redirects to login page for unauthenticated users
     */
    public function test_index_redirects_to_login_for_unauthenticated_users(): void {
      $response = $this->get('api/statuses');

      $response->assertStatus(302);
    }

    /**
     * Test if store task route creates a task in the database
     */
    public function test_create_task(): void {
      $user = User::factory()->create();
      $statuses = Status::factory()->create();
      $task = Task::factory()->create();
      $response = $this->actingAs($user)->postJson('/api/statuses', [
        'title' => 'Test Task Title',
        'description' => 'Test Description',
        'date' => '1992-01-01',
        'statusId' => 1
      ]);
 
      $response->assertStatus(201)
        ->assertJson([
          'data' => [
            'title' => 'Test Task Title',
            'description' => 'Test Description',
            'due_date' => '1992-01-01',
            'status_id' => 1,
          ]
        ]);
    }

    /**
     * Test if update task route updates a task in the database
     */
    public function test_update_task(): void {
      $user = User::factory()->create();
      $statuses = Status::factory()->create();
      $task = Task::factory()->create();
      $response = $this->actingAs($user)->putJson('/api/statuses/' . $task->id, [
          'title' => 'Test Task Title',
          'description' => 'Test Description',
          'date' => '1992-01-01',
          'status_id' => 1
      ]);

      $response->assertStatus(200)
        ->assertJson([
          'data' => [
          'title' => 'Test Task Title',
          'description' => 'Test Description',
          'due_date' => '1992-01-01',
          'status_id' => 1,
        ]
      ]);
    }

    /**
     * Test if delete task route deletes a task in the database
     */
    public function test_delete_task(): void {
      $user = User::factory()->create();
      $statuses = Status::factory()->create();
      $task = Task::factory()->create();
      $response = $this->actingAs($user)->deleteJson('/api/statuses/' . $task->id);
      $response->assertStatus(200)
            ->assertJson([
              'message' => 'Task Deleted Successfully'
          ]);

      $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /**
     * Test if task status is changed
     */
    public function test_sort_task(): void {
      $user = User::factory()->create();
      $statuses = Status::factory()->create();
      $task = Task::factory()->create();

      $response = $this->actingAs($user)->postJson('/api/statuses/' . $task->id . '/sort', [
        'newStatusId' => 1,
      ]);
      $response->assertStatus(200)
            ->assertJson([
              'message' => 'Task Sorted Successfully'
          ]);
    }
}
