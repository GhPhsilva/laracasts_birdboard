<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ProjectTasksTest extends TestCase
{

    use RefreshDatabase;

    public function teste_a_project_can_have_tasks()
    {

        $this->singIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $task_text = 'Test task';
        $this->post($project->path() . '/tasks', ['body' => $task_text]);

        $this->get($project->path())
            ->assertSee($task_text);
    }


    public function test_a_task_requires_a_body()
    {
        $this->singIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
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
        $this->singIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $task = $project->addTask('Test Task');

        $this->patch($project->path() . '/tasks/' . $task->id, [
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

        $project = Project::factory()->create();
        $task = $project->addTask('Test task');

        $this->patch($task->path(), ['body' => 'Changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed']);
    }
}
