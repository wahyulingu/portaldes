<?php

namespace Tests\Feature\Http\Dashboard\Sid\Penduduk\Kelompok;

use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompokKategori;
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

    public function testCreateScreenOfCategoriesCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.penduduk.kelompok.kategori'));

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/penduduk/kelompok/kategori/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Penduduk/Kelompok/Kategori/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfCategories(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/penduduk/kelompok/kategori/create')
            ->assertForbidden();
    }

    public function testCanStoreNewCategory(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.penduduk.kelompok.kategori'));

        $kategori = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/penduduk/kelompok/kategori', $kategori)
            ->assertRedirectToRoute('dashboard.sid.penduduk.kelompok.kategori.index');

        $this->assertDatabaseHas(SidPendudukKelompokKategori::class, $kategori);
    }

    public function testOnlyAuthorizedUserCanStoreNewCategory(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/penduduk/kelompok/kategori')
            ->assertForbidden();
    }

    public function testIndexScreenOfCategoriesCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.penduduk.kelompok.kategori'));

        SidPendudukKelompokKategori::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/penduduk/kelompok/kategori')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Penduduk/Kelompok/Kategori/Index')
                ->has('kategori', fn (AssertableInertia $kategori) => $kategori
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testCategoriesCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.penduduk.kelompok.kategori'));

        /**
         * @var SidPendudukKelompokKategori
         */
        $kategori = SidPendudukKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/penduduk/kelompok/kategori?keyword=%s', substr($kategori->keterangan, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Penduduk/Kelompok/Kategori/Index')
                ->has('kategori', fn (AssertableInertia $kategori) => $kategori
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfCategories(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.sid.penduduk.kelompok.kategori.index', absolute: true))
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedCategoryCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidPendudukKelompokKategori
         */
        $kategori = SidPendudukKelompokKategori::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.penduduk.kelompok.kategori'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/penduduk/kelompok/kategori/%s/edit', $kategori->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Penduduk/Kelompok/Kategori/Edit')
                ->has('kategori', fn (AssertableInertia $assert) => $assert
                    ->where('id', $kategori->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedCategory(): void
    {
        /**
         * @var SidPendudukKelompokKategori
         */
        $kategori = SidPendudukKelompokKategori::factory()->create();

        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.sid.penduduk.kelompok.kategori.edit', $kategori->getKey(), absolute: true))
            ->assertForbidden();
    }

    public function testCanUpdateSelectedCategory(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.penduduk.kelompok.kategori'));

        $kategori = SidPendudukKelompokKategori::factory()->create();

        $newData = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/penduduk/kelompok/kategori/%s', $kategori->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.penduduk.kelompok.kategori.show', $kategori->getKey());

        $this->assertDatabaseHas(SidPendudukKelompokKategori::class, [...$newData, 'id' => $kategori->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedCategory(): void
    {
        $user = User::factory()->create();

        $kategori = SidPendudukKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/penduduk/kelompok/kategori/%s', $kategori->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedCategoryCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.penduduk.kelompok.kategori'));

        $kategori = SidPendudukKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/penduduk/kelompok/kategori/%s', $kategori->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Penduduk/Kelompok/Kategori/Show')
                ->has('kategori', fn (AssertableInertia $renderedCategory) => $renderedCategory
                    ->where('id', $kategori->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedCategory(): void
    {
        $user = User::factory()->create();

        $kategori = SidPendudukKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/penduduk/kelompok/kategori/%s', $kategori->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedCategory(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.penduduk.kelompok.kategori'));

        $kategori = SidPendudukKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/penduduk/kelompok/kategori/%s', $kategori->getKey()))
            ->assertRedirectToRoute('dashboard.sid.penduduk.kelompok.kategori.index');

        $this->assertNull($kategori->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedCategory(): void
    {
        $user = User::factory()->create();

        $kategori = SidPendudukKelompokKategori::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/penduduk/kelompok/kategori/%s', $kategori->getKey()))
            ->assertForbidden();
    }
}
