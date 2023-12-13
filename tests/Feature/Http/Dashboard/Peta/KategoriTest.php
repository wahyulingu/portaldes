<?php

namespace Tests\Feature\Http\Dashboard\Peta\Kategori;

use App\Enumerations\TipePeta;
use App\Models\Peta\PetaKategori;
use App\Models\Peta\PetaSimbol;
use App\Models\Peta\PetaWarna;
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

    public function testCreateScreenOfKategoriCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.kategori'));

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/kategori/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Kategori/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfKategori(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/peta/kategori/create')
            ->assertForbidden();
    }

    public function testCanStoreNewKategori(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.kategori'));

        $kategori = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
            'tipe' => TipePeta::values()->random(),
            'warna_id' => PetaWarna::factory()->create()->getKey(),
            'simbol_id' => PetaSimbol::factory()->create()->getKey(),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/peta/kategori', $kategori)
            ->assertRedirectToRoute('dashboard.peta.kategori.index');

        $this->assertDatabaseHas(PetaKategori::class, $kategori);
    }

    public function testOnlyAuthorizedUserCanStoreNewKategori(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/peta/kategori')
            ->assertForbidden();
    }

    public function testIndexScreenOfKategoriCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.kategori'));

        PetaKategori::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/kategori')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Kategori/Index')
                ->has('kategori', fn (AssertableInertia $kategori) => $kategori
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testKategoriCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.kategori'));

        /**
         * @var PetaKategori
         */
        $kategori = PetaKategori::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/kategori?keyword=%s', substr($kategori->keterangan, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Kategori/Index')
                ->has('kategori', fn (AssertableInertia $kategori) => $kategori
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfKategori(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.kategori.index', absolute: true))
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedKategoriCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var PetaKategori
         */
        $kategori = PetaKategori::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.kategori'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/kategori/%s/edit', $kategori->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Kategori/Edit')
                ->has('kategori', fn (AssertableInertia $assert) => $assert
                    ->where('id', $kategori->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedKategori(): void
    {
        /**
         * @var PetaKategori
         */
        $kategori = PetaKategori::factory()->create();

        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.kategori.edit', $kategori->getKey(), absolute: true))
            ->assertForbidden();
    }

    public function testCanUpdateSelectedKategori(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.kategori'));

        $kategori = PetaKategori::factory()->create();

        $newData = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/kategori/%s', $kategori->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.peta.kategori.show', $kategori->getKey());

        $this->assertDatabaseHas(PetaKategori::class, [...$newData, 'id' => $kategori->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedKategori(): void
    {
        $user = User::factory()->create();

        $kategori = PetaKategori::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/kategori/%s', $kategori->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedKategoriCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.peta.kategori'));

        $kategori = PetaKategori::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/kategori/%s', $kategori->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Kategori/Show')
                ->has('kategori', fn (AssertableInertia $renderedKategori) => $renderedKategori
                    ->where('id', $kategori->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedKategori(): void
    {
        $user = User::factory()->create();

        $kategori = PetaKategori::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/kategori/%s', $kategori->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedKategori(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.peta.kategori'));

        $kategori = PetaKategori::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/kategori/%s', $kategori->getKey()))
            ->assertRedirectToRoute('dashboard.peta.kategori.index');

        $this->assertNull($kategori->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedKategori(): void
    {
        $user = User::factory()->create();

        $kategori = PetaKategori::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/kategori/%s', $kategori->getKey()))
            ->assertForbidden();
    }
}
