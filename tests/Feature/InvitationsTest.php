<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\ProjectTasksController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{

    use RefreshDatabase;
    function test_a_project_can_invite_a_user()
    {
        $this->withExceptionHandling();
        $project = ProjectFactory::create();

        $userToInvite = User::factory()->create();
        $this->actingAs($project->owner)->post($project->path() . '/invitations', ['email' => $userToInvite->email]);
        $this->assertTrue($project->members->contains($userToInvite));
    }

    function test_invited_email_address_must_be_associated_with_a_valid_birdboard_account()
    {
        $project = ProjectFactory::create();
        
        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', ['email' => 'notausr@example.com'])
            ->assertSessionHasErrors('email');
    }

    function test_invited_users_may_update_project_details()
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
