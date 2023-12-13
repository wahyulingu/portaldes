<?php

namespace Tests\Feature\Http\Dashboard\Peta\Warna;

use App\Models\Peta\PetaWarna;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class WarnaTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfWarnaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.warna'));

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/warna/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Warna/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfWarna(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/peta/warna/create')
            ->assertForbidden();
    }

    public function testCanStoreNewWarna(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.warna'));

        $warna = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
            'kode' => '#ffffff',
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/peta/warna', $warna)
            ->assertRedirectToRoute('dashboard.peta.warna.index');

        $this->assertDatabaseHas(PetaWarna::class, $warna);
    }

    public function testOnlyAuthorizedUserCanStoreNewWarna(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/peta/warna')
            ->assertForbidden();
    }

    public function testIndexScreenOfWarnaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.warna'));

        PetaWarna::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/warna')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Warna/Index')
                ->has('warna', fn (AssertableInertia $warna) => $warna
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testWarnaCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.warna'));

        /**
         * @var PetaWarna
         */
        $warna = PetaWarna::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/warna?keyword=%s', substr($warna->keterangan, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Warna/Index')
                ->has('warna', fn (AssertableInertia $warna) => $warna
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfWarna(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.warna.index', absolute: true))
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedWarnaCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var PetaWarna
         */
        $warna = PetaWarna::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.warna'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/warna/%s/edit', $warna->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Warna/Edit')
                ->has('warna', fn (AssertableInertia $assert) => $assert
                    ->where('id', $warna->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedWarna(): void
    {
        /**
         * @var PetaWarna
         */
        $warna = PetaWarna::factory()->create();

        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.warna.edit', $warna->getKey(), absolute: true))
            ->assertForbidden();
    }

    public function testCanUpdateSelectedWarna(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.warna'));

        $warna = PetaWarna::factory()->create();

        $newData = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
            'kode' => '#ffffff',
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/warna/%s', $warna->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.peta.warna.show', $warna->getKey());

        $this->assertDatabaseHas(PetaWarna::class, [...$newData, 'id' => $warna->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedWarna(): void
    {
        $user = User::factory()->create();

        $warna = PetaWarna::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/warna/%s', $warna->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedWarnaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.peta.warna'));

        $warna = PetaWarna::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/warna/%s', $warna->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Warna/Show')
                ->has('warna', fn (AssertableInertia $renderedWarna) => $renderedWarna
                    ->where('id', $warna->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedWarna(): void
    {
        $user = User::factory()->create();

        $warna = PetaWarna::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/warna/%s', $warna->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedWarna(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.peta.warna'));

        $warna = PetaWarna::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/warna/%s', $warna->getKey()))
            ->assertRedirectToRoute('dashboard.peta.warna.index');

        $this->assertNull($warna->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedWarna(): void
    {
        $user = User::factory()->create();

        $warna = PetaWarna::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/warna/%s', $warna->getKey()))
            ->assertForbidden();
    }
}
