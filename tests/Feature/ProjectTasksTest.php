<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTasksTest extends TestCase
{

    use RefreshDatabase;

    public function teste_a_project_can_have_tasks()
    {

        $project = ProjectFactory::create();

        $task_text = 'Test task';
        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', ['body' => $task_text]);

        $this->get($project->path())
            ->assertSee($task_text);
    }


    public function test_a_task_requires_a_body()
    {
        $project = ProjectFactory::create();

        $attributes = Task::factory()->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }

    public function test_it_can_add_a_task()
    {

        $project = Project::factory()->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }

    public function test_only_the_owner_of_a_project_may_add_tasks()
    {
        $this->singIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    public function test_a_task_can_be_updated()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    public function test_only_the_owner_of_a_task_may_update_a_task()
    {
        $this->singIn();
        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks->first()->path(), ['body' => 'Changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed']);
    }
}
