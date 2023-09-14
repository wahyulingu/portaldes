<?php

namespace Tests\Feature\Http\Dashboard\Sid;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IdentitasTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testEditScreenOfIdentitasCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.identitas'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/identitas/edit'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Identitas/Edit')
                ->has('identitas', fn (AssertableInertia $data) => $data
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfIdentitas(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/identitas')
            ->assertForbidden();
    }

    public function testCanUpdateIdentitas(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.identitas'));

        $newData = ['alamat' => $this->faker->address];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/identitas'), $newData)
            ->assertRedirectToRoute('dashboard.sid.identitas.show');
    }

    public function testOnlyAuthorizedUserCanUpdateIdentitas(): void
    {
        $user = User::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/identitas'))
            ->assertForbidden();
    }

    public function testShowScreenOfIdentitasCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.identitas'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/identitas'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Identitas/Show')
                ->has('identitas', fn (AssertableInertia $renderedIdentitas) => $renderedIdentitas
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfIdentitas(): void
    {
        $user = User::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/identitas'))
            ->assertForbidden();
    }
}
