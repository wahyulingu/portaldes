<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTeamNameTest extends TestCase
{
    use RefreshDatabase;

    public function testTeamNamesCanBeUpdated(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->put('/teams/'.$user->currentTeam->id, [
            'name' => 'Test Team',
        ]);

        $this->assertCount(1, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->currentTeam->fresh()->name);
    }
}
