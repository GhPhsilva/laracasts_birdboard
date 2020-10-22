<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    function test_creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activitys);

        $this->assertEquals('created', $project->activitys->first()->description);
    }

    public function test_updating_a_project()
    {
        $project = ProjectFactory::create();

        $originalTitle = $project->title;

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activitys);

        tap($project->activitys->last(), function ($activity) use ($originalTitle, $project) {
            $this->assertEquals('updated', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Changed']
            ];

            $this->assertEquals($expected, $activity->changes);
        });

        $this->assertEquals('updated', $project->activitys->last()->description);
    }

    public function test_creating_a_new_task()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();
        $this->assertCount(2, $project->activitys);

        tap($project->activitys->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(\App\Models\Task::class, $activity->subject);
        });
    }

    public function test_completing_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), ['body' => 'Foobar', 'completed' => true]);
        $this->assertCount(3, $project->activitys);

        tap($project->activitys->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(\App\Models\Task::class, $activity->subject);
        });
    }

    public function test_incompleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), ['body' => 'Foobar', 'completed' => true]);

        $this->assertCount(3, $project->activitys);

        $this->assertEquals('completed_task', $project->activitys->last()->description);

        $project = $project->fresh();

        $this->patch($project->tasks->first()->path(), ['body' => 'Foobar', 'completed' => false]);

        $this->assertCount(4, $project->activitys);

        $this->assertEquals('incompleted_task', $project->activitys->last()->description);
    }

    public function test_deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks->first()->delete();

        $this->assertCount(3, $project->activitys);
    }
}
