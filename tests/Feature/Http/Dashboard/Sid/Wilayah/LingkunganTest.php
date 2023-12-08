<?php

namespace Tests\Feature\Http\Dashboard\Sid\Wilayah;

use App\Models\Sid\Penduduk\SidPenduduk;
use App\Models\Sid\Wilayah\SidWilayahLingkungan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class LingkunganTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfLingkunganCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.wilayah.lingkungan'));

        SidPenduduk::factory(24)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/wilayah/lingkungan/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/Lingkungan/Create')
                ->has('penduduk', SidPenduduk::count()));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfLingkungan(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/wilayah/lingkungan/create')
            ->assertForbidden();
    }

    public function testCanStoreNewLingkungan(): void
    {
        $user = User::factory()->create();
        $penduduk = SidPenduduk::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.wilayah.lingkungan'));

        $lingkungan = [
            'ketua_id' => $penduduk->getKey(),
            'nama' => $this->faker->streetName,
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/wilayah/lingkungan', $lingkungan)
            ->assertSuccessful();

        $this->assertDatabaseHas(SidWilayahLingkungan::class, $lingkungan);
    }

    public function testOnlyAuthorizedUserCanStoreNewLingkungan(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/wilayah/lingkungan')
            ->assertForbidden();
    }

    public function testIndexScreenOfLingkunganCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.wilayah.lingkungan'));

        SidWilayahLingkungan::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/wilayah/lingkungan')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/Lingkungan/Index')
                ->has('lingkungan', fn (AssertableInertia $lingkungan) => $lingkungan
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testLingkunganCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.wilayah.lingkungan'));

        /**
         * @var SidWilayahLingkungan
         */
        $lingkungan = SidWilayahLingkungan::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/lingkungan?keyword=%s', substr($lingkungan->nama, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/Lingkungan/Index')
                ->has('lingkungan', fn (AssertableInertia $lingkungan) => $lingkungan
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfLingkungan(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/wilayah/lingkungan')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedLingkunganCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidWilayahLingkungan
         */
        $lingkungan = SidWilayahLingkungan::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.wilayah.lingkungan'));

        SidPenduduk::factory(24)->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/lingkungan/%s/edit', $lingkungan->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/Lingkungan/Edit')
                ->has('lingkungan', fn (AssertableInertia $data) => $data
                    ->where($lingkungan->getKeyName(), $lingkungan->getKey())
                    ->etc())
                ->has('penduduk', SidPenduduk::count()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedLingkungan(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/wilayah/lingkungan')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedLingkungan(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.wilayah.lingkungan'));

        $lingkungan = SidWilayahLingkungan::factory()->create();

        $newData = ['nama' => $this->faker->streetName];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/wilayah/lingkungan/%s', $lingkungan->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.wilayah.lingkungan.show', $lingkungan->getKey());

        $this->assertDatabaseHas(SidWilayahLingkungan::class, [...$newData, $lingkungan->getKeyName() => $lingkungan->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedLingkungan(): void
    {
        $user = User::factory()->create();

        $lingkungan = SidWilayahLingkungan::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/wilayah/lingkungan/%s', $lingkungan->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedLingkunganCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.wilayah.lingkungan'));

        $lingkungan = SidWilayahLingkungan::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/lingkungan/%s', $lingkungan->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/Lingkungan/Show')
                ->has('lingkungan', fn (AssertableInertia $renderedLingkungan) => $renderedLingkungan
                    ->where($lingkungan->getKeyName(), $lingkungan->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedLingkungan(): void
    {
        $user = User::factory()->create();

        $lingkungan = SidWilayahLingkungan::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/lingkungan/%s', $lingkungan->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedLingkungan(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.wilayah.lingkungan'));

        $lingkungan = SidWilayahLingkungan::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/wilayah/lingkungan/%s', $lingkungan->getKey()))
            ->assertRedirectToRoute('dashboard.sid.wilayah.lingkungan.index');

        $this->assertNull($lingkungan->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedLingkungan(): void
    {
        $user = User::factory()->create();

        $lingkungan = SidWilayahLingkungan::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/wilayah/lingkungan/%s', $lingkungan->getKey()))
            ->assertForbidden();
    }
}
