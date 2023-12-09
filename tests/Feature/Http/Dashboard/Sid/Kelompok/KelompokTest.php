<?php

namespace Tests\Feature\Http\Dashboard\Sid\Kelompok;

use App\Models\Sid\Kelompok\SidKelompok;
use App\Models\Sid\Kelompok\SidKelompokKategori;
use App\Models\Sid\SidPenduduk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class KelompokTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfKelompokCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.kelompok'));

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/kelompok/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Kelompok/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfKelompok(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/kelompok/create')
            ->assertForbidden();
    }

    public function testCanStoreNewKelompok(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.kelompok'));

        $kelompok = [
            'ketua_id' => SidPenduduk::factory()->create()->getKey(),
            'kategori_id' => SidKelompokKategori::factory()->create()->getKey(),
            'nama' => $this->faker->words(3, true),
            'kode' => Str::random(10),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/kelompok', $kelompok)
            ->assertRedirectToRoute('dashboard.sid.kelompok.index');

        $this->assertDatabaseHas(SidKelompok::class, $kelompok);
    }

    public function testOnlyAuthorizedUserCanStoreNewKelompok(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/kelompok')
            ->assertForbidden();
    }

    public function testIndexScreenOfKelompokCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.kelompok'));

        SidKelompok::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/kelompok')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Kelompok/Index')
                ->has('kelompok', fn (AssertableInertia $kelompok) => $kelompok
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testKelompokCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.kelompok'));

        /**
         * @var SidKelompok
         */
        $kelompok = SidKelompok::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/kelompok?keyword=%s', substr($kelompok->keterangan, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Kelompok/Index')
                ->has('kelompok', fn (AssertableInertia $kelompok) => $kelompok
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfKelompok(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.sid.kelompok.index', absolute: true))
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedKelompokCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidKelompok
         */
        $kelompok = SidKelompok::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.kelompok'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/kelompok/%s/edit', $kelompok->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Kelompok/Edit')
                ->has('kelompok', fn (AssertableInertia $assert) => $assert
                    ->where('id', $kelompok->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedKelompok(): void
    {
        /**
         * @var SidKelompok
         */
        $kelompok = SidKelompok::factory()->create();

        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.sid.kelompok.edit', $kelompok->getKey(), absolute: true))
            ->assertForbidden();
    }

    public function testCanUpdateSelectedKelompok(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.kelompok'));

        $kelompok = SidKelompok::factory()->create();

        $newData = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/kelompok/%s', $kelompok->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.kelompok.show', $kelompok->getKey());

        $this->assertDatabaseHas(SidKelompok::class, [...$newData, 'id' => $kelompok->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedKelompok(): void
    {
        $user = User::factory()->create();

        $kelompok = SidKelompok::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/kelompok/%s', $kelompok->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedKelompokCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.kelompok'));

        $kelompok = SidKelompok::factory()->create();

        $penduduk = SidPenduduk::factory(20)->create();

        $kelompok->penduduk()->saveMany($penduduk);

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/kelompok/%s', $kelompok->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Kelompok/Show')
                ->has('kelompok', fn (AssertableInertia $renderedKelompok) => $renderedKelompok
                    ->has('ketua')
                    ->has('penduduk', $penduduk->count())
                    ->where('id', $kelompok->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedKelompok(): void
    {
        $user = User::factory()->create();

        $kelompok = SidKelompok::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/kelompok/%s', $kelompok->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedKelompok(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.kelompok'));

        $kelompok = SidKelompok::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/kelompok/%s', $kelompok->getKey()))
            ->assertRedirectToRoute('dashboard.sid.kelompok.index');

        $this->assertNull($kelompok->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedKelompok(): void
    {
        $user = User::factory()->create();

        $kelompok = SidKelompok::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/kelompok/%s', $kelompok->getKey()))
            ->assertForbidden();
    }
}
