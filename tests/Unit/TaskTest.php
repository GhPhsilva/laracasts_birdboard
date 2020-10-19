<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;

use function PHPUnit\Framework\assertInstanceOf;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{


    use RefreshDatabase;

    public function test_it_has_a_path()
    {
        $task = Task::factory()->create();
        
        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    function test_it_belongs_to_a_project()
    {
        $task = Task::factory()->create();
        return assertInstanceOf(Project::class, $task->project);
    }
}
