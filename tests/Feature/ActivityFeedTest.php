<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    function test_creating_a_project_generates_a_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activitys);

        $this->assertEquals('created', $project->activitys->first()->description);
    }

    public function test_updating_a_project_generates_activity()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activitys);

        $this->assertEquals('updated', $project->activitys->last()->description);
    }

    public function test_creating_a_new_task_records_project_activit()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $this->assertCount(2, $project->activitys);
        $this->assertEquals('created_task', $project->activitys->last()->description);
    }

    public function test_completing_a_task_records_project_activit()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), ['body' => 'Foobar', 'completed' => true]);
        $this->assertCount(3, $project->activitys);
        $this->assertEquals('completed_task', $project->activitys->last()->description);
    }
}
