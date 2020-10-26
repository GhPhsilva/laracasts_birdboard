<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\ProjectTasksController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{

    use RefreshDatabase;

    function test_a_project_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $project->invite($newUser = \App\Models\User::factory()->create());

        $this->singIn($newUser);
        $this->post(action([ProjectTasksController::class, 'store'], ['project' => $project]), $task = ['body' => 'Foo task']);

        $this->assertDatabaseHas('tasks', $task);
        // tenho um projeto e o dono convida outro usuario ele pode adicionar tarefas
    }
}
