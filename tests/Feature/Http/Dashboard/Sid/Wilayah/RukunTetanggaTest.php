<?php

namespace Tests\Feature\Http\Dashboard\Sid\Wilayah;

use App\Models\Sid\Penduduk\SidPenduduk;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Models\Sid\Wilayah\SidWilayahRukunWarga;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class RukunTetanggaTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfRukunTetanggaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.wilayah.rukunTetangga'));

        SidPenduduk::factory(24)->create();
        SidWilayahRukunWarga::factory(24)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/wilayah/rukun-tetangga/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/RukunTetangga/Create')
                ->has('rukunWarga', SidWilayahRukunWarga::count())
                ->has('penduduk', SidPenduduk::count()));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfRukunTetangga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/wilayah/rukun-tetangga/create')
            ->assertForbidden();
    }

    public function testCanStoreNewRukunTetangga(): void
    {
        $user = User::factory()->create();
        $penduduk = SidPenduduk::factory()->create();
        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.wilayah.rukunTetangga'));

        $rukunTetangga = [
            'rukun_warga_id' => $rukunTetangga->getKey(),
            'ketua_id' => $penduduk->getKey(),
            'nama' => $this->faker->streetName,
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/wilayah/rukun-tetangga', $rukunTetangga)
            ->assertSuccessful();

        $this->assertDatabaseHas(SidWilayahRukunTetangga::class, $rukunTetangga);
    }

    public function testOnlyAuthorizedUserCanStoreNewRukunTetangga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/wilayah/rukun-tetangga')
            ->assertForbidden();
    }

    public function testIndexScreenOfRukunTetanggaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.wilayah.rukunTetangga'));

        SidWilayahRukunTetangga::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/wilayah/rukun-tetangga')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/RukunTetangga/Index')
                ->has('rukun_tetangga', fn (AssertableInertia $rukunTetangga) => $rukunTetangga
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testRukunTetanggaCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.wilayah.rukunTetangga'));

        /**
         * @var SidWilayahRukunTetangga
         */
        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/rukun-tetangga?keyword=%s', substr($rukunTetangga->nama, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/RukunTetangga/Index')
                ->has('rukun_tetangga', fn (AssertableInertia $rukunTetangga) => $rukunTetangga
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfRukunTetangga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/wilayah/rukun-tetangga')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedRukunTetanggaCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidWilayahRukunTetangga
         */
        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.wilayah.rukunTetangga'));

        SidPenduduk::factory(24)->create();
        SidWilayahRukunWarga::factory(24)->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/rukun-tetangga/%s/edit', $rukunTetangga->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/RukunTetangga/Edit')
                ->has('rukun_tetangga', fn (AssertableInertia $data) => $data
                    ->where($rukunTetangga->getKeyName(), $rukunTetangga->getKey())
                    ->etc())
                ->has('rukunWarga', SidWilayahRukunWarga::count())
                ->has('penduduk', SidPenduduk::count()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedRukunTetangga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/wilayah/rukun-tetangga')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedRukunTetangga(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.wilayah.rukunTetangga'));

        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $newData = ['nama' => trim($this->faker->streetName)];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/wilayah/rukun-tetangga/%s', $rukunTetangga->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.wilayah.rukun-tetangga.show', $rukunTetangga->getKey());

        $this->assertDatabaseHas(SidWilayahRukunTetangga::class, [...$newData, $rukunTetangga->getKeyName() => $rukunTetangga->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedRukunTetangga(): void
    {
        $user = User::factory()->create();

        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/wilayah/rukun-tetangga/%s', $rukunTetangga->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedRukunTetanggaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.wilayah.rukunTetangga'));

        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/rukun-tetangga/%s', $rukunTetangga->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/RukunTetangga/Show')
                ->has('rukun_tetangga', fn (AssertableInertia $renderedRukunTetangga) => $renderedRukunTetangga
                    ->where($rukunTetangga->getKeyName(), $rukunTetangga->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedRukunTetangga(): void
    {
        $user = User::factory()->create();

        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/rukun-tetangga/%s', $rukunTetangga->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedRukunTetangga(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.wilayah.rukunTetangga'));

        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/wilayah/rukun-tetangga/%s', $rukunTetangga->getKey()))
            ->assertRedirectToRoute('dashboard.sid.wilayah.rukun-tetangga.index');

        $this->assertNull($rukunTetangga->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedRukunTetangga(): void
    {
        $user = User::factory()->create();

        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/wilayah/rukun-tetangga/%s', $rukunTetangga->getKey()))
            ->assertForbidden();
    }
}
