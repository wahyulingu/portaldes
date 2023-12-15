<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Tests\TestCase;

class CreateTeamTest extends TestCase
{
    use RefreshDatabase;

    public function testTeamsCanBeCreated(): void
    {
        if (!Features::hasTeamFeatures()) {
            $this->markTestSkipped('Team feature is not enabled.');

            return;
        }

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->post('/teams', [
            'name' => 'Test Team',
        ]);

        $this->assertCount(2, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->fresh()->ownedTeams()->latest('id')->first()->name);
    }
}
