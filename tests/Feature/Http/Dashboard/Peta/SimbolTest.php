<?php

namespace Tests\Feature\Http\Dashboard\Peta\Simbol;

use App\Models\Peta\PetaSimbol;
use App\Models\User;
use App\Repositories\FileRepository;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SimbolTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfSimbolCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.simbol'));

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/simbol/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Simbol/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfSimbol(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/peta/simbol/create')
            ->assertForbidden();
    }

    public function testCanStoreNewSimbol(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.simbol'));

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $gambar = UploadedFile::fake()->image('simbol.png');

        $simbol = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/peta/simbol', [...$simbol, ...compact('gambar')])
            ->assertRedirectToRoute('dashboard.peta.simbol.index');

        $fakeStorage->assertExists($gambar->hashName('peta/simbol'));

        $this->assertDatabaseHas(PetaSimbol::class, $simbol);
    }

    public function testOnlyAuthorizedUserCanStoreNewSimbol(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/peta/simbol')
            ->assertForbidden();
    }

    public function testIndexScreenOfSimbolCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.simbol'));

        PetaSimbol::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/simbol')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Simbol/Index')
                ->has('simbol', fn (AssertableInertia $simbol) => $simbol
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testSimbolCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.simbol'));

        /**
         * @var PetaSimbol
         */
        $simbol = PetaSimbol::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/simbol?keyword=%s', substr($simbol->keterangan, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Simbol/Index')
                ->has('simbol', fn (AssertableInertia $simbol) => $simbol
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfSimbol(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.simbol.index', absolute: true))
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedSimbolCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var PetaSimbol
         */
        $simbol = PetaSimbol::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.simbol'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/simbol/%s/edit', $simbol->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Simbol/Edit')
                ->has('simbol', fn (AssertableInertia $assert) => $assert
                    ->where('id', $simbol->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedSimbol(): void
    {
        /**
         * @var PetaSimbol
         */
        $simbol = PetaSimbol::factory()->create();

        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.simbol.edit', $simbol->getKey(), absolute: true))
            ->assertForbidden();
    }

    public function testCanUpdateSelectedSimbol(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.simbol'));

        $simbol = PetaSimbol::factory()->create();

        $newData = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/simbol/%s', $simbol->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.peta.simbol.show', $simbol->getKey());

        $this->assertDatabaseHas(PetaSimbol::class, [...$newData, 'id' => $simbol->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedSimbol(): void
    {
        $user = User::factory()->create();

        $simbol = PetaSimbol::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/simbol/%s', $simbol->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedSimbolCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.peta.simbol'));

        $simbol = PetaSimbol::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/simbol/%s', $simbol->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Simbol/Show')
                ->has('simbol', fn (AssertableInertia $renderedSimbol) => $renderedSimbol
                    ->where('id', $simbol->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedSimbol(): void
    {
        $user = User::factory()->create();

        $simbol = PetaSimbol::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/simbol/%s', $simbol->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedSimbol(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.peta.simbol'));

        $simbol = PetaSimbol::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/simbol/%s', $simbol->getKey()))
            ->assertRedirectToRoute('dashboard.peta.simbol.index');

        $this->assertNull($simbol->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedSimbol(): void
    {
        $user = User::factory()->create();

        $simbol = PetaSimbol::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/simbol/%s', $simbol->getKey()))
            ->assertForbidden();
    }
}
