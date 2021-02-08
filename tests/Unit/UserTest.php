<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_user_has_projects()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    public function teste_a_user_has_acessible_projects()
    {
        $john = $this->singIn();

        ProjectFactory::ownedBy($john)->create();

        $this->assertCount(1, $john->accessibleProjects());

        $sally = User::factory()->create();
        $nick = User::factory()->create();

        $projct = ProjectFactory::ownedBy($sally)->create();
        $projct->invite($nick);

        $this->assertCount(1, $john->accessibleProjects());

        $projct->invite($john);

        $this->assertCount(2, $john->accessibleProjects());
    }
}
