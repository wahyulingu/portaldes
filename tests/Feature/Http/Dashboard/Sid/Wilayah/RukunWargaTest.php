<?php

namespace Tests\Feature\Http\Dashboard\Sid\Wilayah;

use App\Models\Sid\SidPenduduk;
use App\Models\Sid\Wilayah\SidWilayahLingkungan;
use App\Models\Sid\Wilayah\SidWilayahRukunWarga;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class RukunWargaTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfRukunWargaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.wilayah.rukunWarga'));

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/wilayah/rukun-warga/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/RukunWarga/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfRukunWarga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/wilayah/rukun-warga/create')
            ->assertForbidden();
    }

    public function testCanStoreNewRukunWarga(): void
    {
        $user = User::factory()->create();
        $penduduk = SidPenduduk::factory()->create();
        $lingkungan = SidWilayahLingkungan::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.wilayah.rukunWarga'));

        $rukunWarga = [
            'lingkungan_id' => $lingkungan->getKey(),
            'ketua_id' => $penduduk->getKey(),
            'nama' => $this->faker->streetName,
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/wilayah/rukun-warga', $rukunWarga)
            ->assertSuccessful();

        $this->assertDatabaseHas(SidWilayahRukunWarga::class, $rukunWarga);
    }

    public function testOnlyAuthorizedUserCanStoreNewRukunWarga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/wilayah/rukun-warga')
            ->assertForbidden();
    }

    public function testIndexScreenOfRukunWargaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.wilayah.rukunWarga'));

        SidWilayahRukunWarga::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/wilayah/rukun-warga')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/RukunWarga/Index')
                ->has('rukun_warga', fn (AssertableInertia $rukunWarga) => $rukunWarga
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testRukunWargaCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.wilayah.rukunWarga'));

        /**
         * @var SidWilayahRukunWarga
         */
        $rukunWarga = SidWilayahRukunWarga::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/rukun-warga?keyword=%s', substr($rukunWarga->nama, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/RukunWarga/Index')
                ->has('rukun_warga', fn (AssertableInertia $rukunWarga) => $rukunWarga
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfRukunWarga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/wilayah/rukun-warga')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedRukunWargaCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidWilayahRukunWarga
         */
        $rukunWarga = SidWilayahRukunWarga::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.wilayah.rukunWarga'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/rukun-warga/%s/edit', $rukunWarga->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/RukunWarga/Edit')
                ->has('rukun_warga', fn (AssertableInertia $data) => $data
                    ->where($rukunWarga->getKeyName(), $rukunWarga->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedRukunWarga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/wilayah/rukun-warga')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedRukunWarga(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.wilayah.rukunWarga'));

        $rukunWarga = SidWilayahRukunWarga::factory()->create();

        $newData = ['nama' => $this->faker->streetName];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/wilayah/rukun-warga/%s', $rukunWarga->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.wilayah.rukun-warga.show', $rukunWarga->getKey());

        $this->assertDatabaseHas(SidWilayahRukunWarga::class, [...$newData, $rukunWarga->getKeyName() => $rukunWarga->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedRukunWarga(): void
    {
        $user = User::factory()->create();

        $rukunWarga = SidWilayahRukunWarga::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/wilayah/rukun-warga/%s', $rukunWarga->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedRukunWargaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.wilayah.rukunWarga'));

        $rukunWarga = SidWilayahRukunWarga::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/rukun-warga/%s', $rukunWarga->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Wilayah/RukunWarga/Show')
                ->has('rukun_warga', fn (AssertableInertia $renderedRukunWarga) => $renderedRukunWarga
                    ->where($rukunWarga->getKeyName(), $rukunWarga->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedRukunWarga(): void
    {
        $user = User::factory()->create();

        $rukunWarga = SidWilayahRukunWarga::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/wilayah/rukun-warga/%s', $rukunWarga->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedRukunWarga(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.wilayah.rukunWarga'));

        $rukunWarga = SidWilayahRukunWarga::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/wilayah/rukun-warga/%s', $rukunWarga->getKey()))
            ->assertRedirectToRoute('dashboard.sid.wilayah.rukun-warga.index');

        $this->assertNull($rukunWarga->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedRukunWarga(): void
    {
        $user = User::factory()->create();

        $rukunWarga = SidWilayahRukunWarga::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/wilayah/rukun-warga/%s', $rukunWarga->getKey()))
            ->assertForbidden();
    }
}
