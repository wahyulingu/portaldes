<?php

namespace Tests\Feature\Http\Dashboard\Peta\Garis;

use App\Models\Peta\PetaGaris;
use App\Models\Peta\PetaKategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class GarisTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfGarisCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.garis'));

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/garis/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Garis/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfGaris(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/peta/garis/create')
            ->assertForbidden();
    }

    public function testCanStoreNewGaris(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.garis'));

        $garis = collect([
            'kategori_id' => PetaKategori::factory()->garis()->create()->getKey(),
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
            'path' => [[]],
        ]);

        $this

            ->actingAs($user)
            ->post('/dashboard/peta/garis', $garis->toArray())
            ->assertRedirectToRoute('dashboard.peta.garis.index');

        $garis->put('path', json_encode($garis->get('path')));

        $this->assertDatabaseHas(PetaGaris::class, $garis->toArray());
    }

    public function testOnlyAuthorizedUserCanStoreNewGaris(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/peta/garis')
            ->assertForbidden();
    }

    public function testIndexScreenOfGarisCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.garis'));

        PetaGaris::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/garis')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Garis/Index')
                ->has('garis', fn (AssertableInertia $garis) => $garis
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testGarisCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.garis'));

        /**
         * @var PetaGaris
         */
        $garis = PetaGaris::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/garis?keyword=%s', substr($garis->keterangan, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Garis/Index')
                ->has('garis', fn (AssertableInertia $garis) => $garis
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfGaris(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.garis.index', absolute: true))
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedGarisCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var PetaGaris
         */
        $garis = PetaGaris::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.garis'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/garis/%s/edit', $garis->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Garis/Edit')
                ->has('garis', fn (AssertableInertia $assert) => $assert
                    ->where('id', $garis->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedGaris(): void
    {
        /**
         * @var PetaGaris
         */
        $garis = PetaGaris::factory()->create();

        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.garis.edit', $garis->getKey(), absolute: true))
            ->assertForbidden();
    }

    public function testCanUpdateSelectedGaris(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.garis'));

        $garis = PetaGaris::factory()->create();

        $newData = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/garis/%s', $garis->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.peta.garis.show', $garis->getKey());

        $this->assertDatabaseHas(PetaGaris::class, [...$newData, 'id' => $garis->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedGaris(): void
    {
        $user = User::factory()->create();

        $garis = PetaGaris::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/garis/%s', $garis->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedGarisCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.peta.garis'));

        $garis = PetaGaris::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/garis/%s', $garis->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Garis/Show')
                ->has('garis', fn (AssertableInertia $renderedGaris) => $renderedGaris
                    ->where('id', $garis->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedGaris(): void
    {
        $user = User::factory()->create();

        $garis = PetaGaris::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/garis/%s', $garis->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedGaris(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.peta.garis'));

        $garis = PetaGaris::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/garis/%s', $garis->getKey()))
            ->assertRedirectToRoute('dashboard.peta.garis.index');

        $this->assertNull($garis->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedGaris(): void
    {
        $user = User::factory()->create();

        $garis = PetaGaris::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/garis/%s', $garis->getKey()))
            ->assertForbidden();
    }
}
