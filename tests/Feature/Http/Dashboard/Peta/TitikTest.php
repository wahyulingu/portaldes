<?php

namespace Tests\Feature\Http\Dashboard\Peta\Titik;

use App\Models\Peta\PetaKategori;
use App\Models\Peta\PetaTitik;
use App\Models\User;
use App\Repositories\FileRepository;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class TitikTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfTitikCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.titik'));

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/titik/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Titik/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfTitik(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/peta/titik/create')
            ->assertForbidden();
    }

    public function testCanStoreNewTitik(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.titik'));

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $gambar = UploadedFile::fake()->image('simbol.png');

        $titik = [
            'kategori_id' => PetaKategori::factory()->titik()->create()->getKey(),
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
            'lat' => '1',
            'lng' => '1',
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/peta/titik', [...$titik, ...compact('gambar')])
            ->assertRedirectToRoute('dashboard.peta.titik.index');

        $fakeStorage->assertExists($gambar->hashName('peta/gambar'));

        $this->assertDatabaseHas(PetaTitik::class, $titik);
    }

    public function testOnlyAuthorizedUserCanStoreNewTitik(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/peta/titik')
            ->assertForbidden();
    }

    public function testIndexScreenOfTitikCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.titik'));

        PetaTitik::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/titik')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Titik/Index')
                ->has('titik', fn (AssertableInertia $titik) => $titik
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testTitikCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.titik'));

        /**
         * @var PetaTitik
         */
        $titik = PetaTitik::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/titik?keyword=%s', substr($titik->keterangan, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Titik/Index')
                ->has('titik', fn (AssertableInertia $titik) => $titik
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfTitik(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.titik.index', absolute: true))
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedTitikCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var PetaTitik
         */
        $titik = PetaTitik::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.titik'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/titik/%s/edit', $titik->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Titik/Edit')
                ->has('titik', fn (AssertableInertia $assert) => $assert
                    ->where('id', $titik->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedTitik(): void
    {
        /**
         * @var PetaTitik
         */
        $titik = PetaTitik::factory()->create();

        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.titik.edit', $titik->getKey(), absolute: true))
            ->assertForbidden();
    }

    public function testCanUpdateSelectedTitik(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.titik'));

        $titik = PetaTitik::factory()->create();

        $newData = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/titik/%s', $titik->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.peta.titik.show', $titik->getKey());

        $this->assertDatabaseHas(PetaTitik::class, [...$newData, 'id' => $titik->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedTitik(): void
    {
        $user = User::factory()->create();

        $titik = PetaTitik::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/titik/%s', $titik->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedTitikCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.peta.titik'));

        $titik = PetaTitik::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/titik/%s', $titik->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Titik/Show')
                ->has('titik', fn (AssertableInertia $renderedTitik) => $renderedTitik
                    ->where('id', $titik->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedTitik(): void
    {
        $user = User::factory()->create();

        $titik = PetaTitik::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/titik/%s', $titik->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedTitik(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.peta.titik'));

        $titik = PetaTitik::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/titik/%s', $titik->getKey()))
            ->assertRedirectToRoute('dashboard.peta.titik.index');

        $this->assertNull($titik->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedTitik(): void
    {
        $user = User::factory()->create();

        $titik = PetaTitik::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/titik/%s', $titik->getKey()))
            ->assertForbidden();
    }
}
