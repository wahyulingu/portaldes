<?php

namespace Tests\Feature\Http\Dashboard\Sid;

use App\Models\User;
use App\Repositories\MetaRepository;
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

        $data = [
            'nama_desa' => $this->faker->city,
            'alamat' => $this->faker->address,
            'telepon' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'website' => $this->faker->domainName,
            'kode_desa' => $this->faker->randomDigitNotNull,
            'nama_kepala_desa' => $this->faker->name,
            'kodepos' => $this->faker->randomDigitNotNull,
            'nama_kecamatan' => $this->faker->city,
            'kode_kecamatan' => $this->faker->randomDigitNotNull,
            'nama_kepala_camat' => $this->faker->name,
            'nama_kabupaten' => $this->faker->city,
            'kode_kabupaten' => $this->faker->randomDigitNotNull,
            'provinsi' => $this->faker->randomDigitNotNull,
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/identitas'), $data)
            ->assertRedirectToRoute('dashboard.sid.identitas.show');

        $actualIdentitas = app(MetaRepository::class)->findBySlug('sid-identitas');

        $this->assertNotNull($actualIdentitas);
        $this->assertEquals($data, $actualIdentitas->value);
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
