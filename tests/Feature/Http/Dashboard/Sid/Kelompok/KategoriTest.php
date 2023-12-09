<?php

namespace Tests\Feature\Http\Dashboard\Sid\Kelompok;

use App\Models\Sid\Kelompok\SidKelompokKategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class KategoriTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfKelompokKategoriCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.kelompok.kategori'));

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/kelompok/kategori/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Kelompok/Kategori/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfKelompokKategori(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/kelompok/kategori/create')
            ->assertForbidden();
    }

    public function testCanStoreNewKelompokKategori(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.kelompok.kategori'));

        $kategori = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/kelompok/kategori', $kategori)
            ->assertRedirectToRoute('dashboard.sid.kelompok.kategori.index');

        $this->assertDatabaseHas(SidKelompokKategori::class, $kategori);
    }

    public function testOnlyAuthorizedUserCanStoreNewKelompokKategori(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/kelompok/kategori')
            ->assertForbidden();
    }

    public function testIndexScreenOfKelompokKategoriCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.kelompok.kategori'));

        SidKelompokKategori::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/kelompok/kategori')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Kelompok/Kategori/Index')
                ->has('kategori', fn (AssertableInertia $kategori) => $kategori
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testKelompokKategoriCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.kelompok.kategori'));

        /**
         * @var SidKelompokKategori
         */
        $kategori = SidKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/kelompok/kategori?keyword=%s', substr($kategori->keterangan, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Kelompok/Kategori/Index')
                ->has('kategori', fn (AssertableInertia $kategori) => $kategori
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfKelompokKategori(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.sid.kelompok.kategori.index', absolute: true))
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedKelompokKategoriCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidKelompokKategori
         */
        $kategori = SidKelompokKategori::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.kelompok.kategori'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/kelompok/kategori/%s/edit', $kategori->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Kelompok/Kategori/Edit')
                ->has('kategori', fn (AssertableInertia $assert) => $assert
                    ->where('id', $kategori->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedKelompokKategori(): void
    {
        /**
         * @var SidKelompokKategori
         */
        $kategori = SidKelompokKategori::factory()->create();

        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.sid.kelompok.kategori.edit', $kategori->getKey(), absolute: true))
            ->assertForbidden();
    }

    public function testCanUpdateSelectedKelompokKategori(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.kelompok.kategori'));

        $kategori = SidKelompokKategori::factory()->create();

        $newData = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/kelompok/kategori/%s', $kategori->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.kelompok.kategori.show', $kategori->getKey());

        $this->assertDatabaseHas(SidKelompokKategori::class, [...$newData, 'id' => $kategori->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedKelompokKategori(): void
    {
        $user = User::factory()->create();

        $kategori = SidKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/kelompok/kategori/%s', $kategori->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedKelompokKategoriCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.kelompok.kategori'));

        $kategori = SidKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/kelompok/kategori/%s', $kategori->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Kelompok/Kategori/Show')
                ->has('kategori', fn (AssertableInertia $renderedKelompokKategori) => $renderedKelompokKategori
                    ->where('id', $kategori->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedKelompokKategori(): void
    {
        $user = User::factory()->create();

        $kategori = SidKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/kelompok/kategori/%s', $kategori->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedKelompokKategori(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.kelompok.kategori'));

        $kategori = SidKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/kelompok/kategori/%s', $kategori->getKey()))
            ->assertRedirectToRoute('dashboard.sid.kelompok.kategori.index');

        $this->assertNull($kategori->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedKelompokKategori(): void
    {
        $user = User::factory()->create();

        $kategori = SidKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/kelompok/kategori/%s', $kategori->getKey()))
            ->assertForbidden();
    }
}
