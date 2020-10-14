<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{

    use RefreshDatabase;

    public function test_it_has_a_path() {

        $project = Project::factory()->create();
        
        $this->assertEquals('/projects/'.$project->id, $project->path());
    }

    public function test_it_belongs_to_a_owner() {
        $project = Project::factory()->create();
        
        $this->assertInstanceOf(User::class,$project->owner);
    }
}