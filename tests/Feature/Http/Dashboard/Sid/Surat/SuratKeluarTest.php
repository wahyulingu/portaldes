<?php

namespace Tests\Feature\Http\Dashboard\Sid\Surat;

use App\Models\Sid\SidPenduduk;
use App\Models\Sid\Surat\SidSuratKeluar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SuratKeluarTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfSuratKeluarCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.surat.surat-keluar'));

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/surat/surat-keluar/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Surat/Keluar/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfSuratKeluar(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/surat/surat-keluar/create')
            ->assertForbidden();
    }

    public function testCanStoreNewSuratKeluar(): void
    {
        $user = User::factory()->create();
        $penduduk = SidPenduduk::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.surat.surat-keluar'));

        $suratKeluar = [
            'ketua_id' => $penduduk->getKey(),
            'nama' => $this->faker->streetName,
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/surat/surat-keluar', $suratKeluar)
            ->assertSuccessful();

        $this->assertDatabaseHas(SidSuratKeluar::class, $suratKeluar);
    }

    public function testOnlyAuthorizedUserCanStoreNewSuratKeluar(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/surat/surat-keluar')
            ->assertForbidden();
    }

    public function testIndexScreenOfSuratKeluarCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.surat.surat-keluar'));

        SidSuratKeluar::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/surat/surat-keluar')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Surat/Keluar/Index')
                ->has('suratKeluar', fn (AssertableInertia $suratKeluar) => $suratKeluar
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testSuratKeluarCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.surat.surat-keluar'));

        /**
         * @var SidSuratKeluar
         */
        $suratKeluar = SidSuratKeluar::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/surat/surat-keluar?keyword=%s', substr($suratKeluar->nama, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Surat/Keluar/Index')
                ->has('suratKeluar', fn (AssertableInertia $suratKeluar) => $suratKeluar
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfSuratKeluar(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/surat/surat-keluar')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedSuratKeluarCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidSuratKeluar
         */
        $suratKeluar = SidSuratKeluar::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.surat.surat-keluar'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/surat/surat-keluar/%s/edit', $suratKeluar->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Surat/Keluar/Edit')
                ->has('suratKeluar', fn (AssertableInertia $data) => $data
                    ->where($suratKeluar->getKeyName(), $suratKeluar->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedSuratKeluar(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/surat/surat-keluar')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedSuratKeluar(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.surat.surat-keluar'));

        $suratKeluar = SidSuratKeluar::factory()->create();

        $newData = ['nama' => $this->faker->streetName];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/surat/surat-keluar/%s', $suratKeluar->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.surat.surat-keluar.show', $suratKeluar->getKey());

        $this->assertDatabaseHas(SidSuratKeluar::class, [...$newData, $suratKeluar->getKeyName() => $suratKeluar->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedSuratKeluar(): void
    {
        $user = User::factory()->create();

        $suratKeluar = SidSuratKeluar::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/surat/surat-keluar/%s', $suratKeluar->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedSuratKeluarCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.surat.surat-keluar'));

        $suratKeluar = SidSuratKeluar::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/surat/surat-keluar/%s', $suratKeluar->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Surat/Keluar/Show')
                ->has('suratKeluar', fn (AssertableInertia $renderedSuratKeluar) => $renderedSuratKeluar
                    ->where($suratKeluar->getKeyName(), $suratKeluar->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedSuratKeluar(): void
    {
        $user = User::factory()->create();

        $suratKeluar = SidSuratKeluar::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/surat/surat-keluar/%s', $suratKeluar->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedSuratKeluar(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.surat.surat-keluar'));

        $suratKeluar = SidSuratKeluar::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/surat/surat-keluar/%s', $suratKeluar->getKey()))
            ->assertRedirectToRoute('dashboard.sid.surat.surat-keluar.index');

        $this->assertNull($suratKeluar->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedSuratKeluar(): void
    {
        $user = User::factory()->create();

        $suratKeluar = SidSuratKeluar::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/surat/surat-keluar/%s', $suratKeluar->getKey()))
            ->assertForbidden();
    }
}
