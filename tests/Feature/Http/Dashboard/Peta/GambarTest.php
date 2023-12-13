<?php

namespace Tests\Feature\Http\Dashboard\Peta\Gambar;

use App\Models\Peta\PetaGambar;
use App\Models\Peta\PetaKategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class GambarTest extends TestCase
{
    //     use RefreshDatabase;
    //     use WithFaker;

    //     public function testCreateScreenOfGambarCanBeRendered(): void
    //     {
    //         $user = User::factory()->create();

    //         $user->givePermissionTo(Permission::findOrCreate('create.peta.gambar'));

    //         $this

    //             ->actingAs($user)
    //             ->get('/dashboard/peta/gambar/create')
    //             ->assertOk()
    //             ->assertInertia(fn (AssertableInertia $page) => $page
    //                 ->component('Dashboard/Peta/Gambar/Create'));
    //     }

    //     public function testOnlyAuthorizedUserCanAccessCreateScreenOfGambar(): void
    //     {
    //         $this

    //             ->actingAs(User::factory()->create())
    //             ->get('/dashboard/peta/gambar/create')
    //             ->assertForbidden();
    //     }

    //     public function testCanStoreNewGambar(): void
    //     {
    //         $user = User::factory()->create();

    //         $user->givePermissionTo(Permission::findOrCreate('create.peta.gambar'));

    //         $gambar = collect([
    //             'kategori_id' => PetaKategori::factory()->gambar()->create()->getKey(),
    //             'nama' => $this->faker->words(3, true),
    //             'keterangan' => $this->faker->words(8, true),
    //             'path' => [[[]]],
    //         ]);

    //         $this

    //             ->actingAs($user)
    //             ->post('/dashboard/peta/gambar', $gambar->toArray())
    //             ->assertRedirectToRoute('dashboard.peta.gambar.index');

    //         $gambar->put('path', json_encode($gambar->get('path')));

    //         $this->assertDatabaseHas(PetaGambar::class, $gambar->toArray());
    //     }

    //     public function testOnlyAuthorizedUserCanStoreNewGambar(): void
    //     {
    //         $this

    //             ->actingAs(User::factory()->create())
    //             ->post('/dashboard/peta/gambar')
    //             ->assertForbidden();
    //     }

    //     public function testIndexScreenOfGambarCanBeRendered(): void
    //     {
    //         $user = User::factory()->create();

    //         $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.gambar'));

    //         PetaGambar::factory(5)->create();

    //         $this

    //             ->actingAs($user)
    //             ->get('/dashboard/peta/gambar')
    //             ->assertOk()
    //             ->assertInertia(fn (AssertableInertia $page) => $page
    //                 ->component('Dashboard/Peta/Gambar/Index')
    //                 ->has('gambar', fn (AssertableInertia $gambar) => $gambar
    //                     ->has('data', 5, fn (AssertableInertia $data) => $data
    //                         ->etc())
    //                     ->where('total', 5)
    //                     ->etc()));
    //     }

    //     public function testGambarCanIndexByKeyword(): void
    //     {
    //         $user = User::factory()->create();

    //         $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.gambar'));

    //         /**
    //          * @var PetaGambar
    //          */
    //         $gambar = PetaGambar::factory()->create();

    //         $this

    //             ->actingAs($user)
    //             ->get(sprintf('/dashboard/peta/gambar?keyword=%s', substr($gambar->keterangan, 8, 24)))
    //             ->assertOk()
    //             ->assertInertia(fn (AssertableInertia $page) => $page
    //                 ->component('Dashboard/Peta/Gambar/Index')
    //                 ->has('gambar', fn (AssertableInertia $gambar) => $gambar
    //                     ->has('data', 1, fn (AssertableInertia $data) => $data
    //                         ->etc())
    //                     ->where('total', 1)
    //                     ->etc()));
    //     }

    //     public function testOnlyAuthorizedUserCanAccessIndexScreenOfGambar(): void
    //     {
    //         $this

    //             ->actingAs(User::factory()->create())
    //             ->get(route('dashboard.peta.gambar.index', absolute: true))
    //             ->assertForbidden();
    //     }

    //     public function testEditScreenOfSelectedGambarCanBeRendered(): void
    //     {
    //         $user = User::factory()->create();

    //         /**
    //          * @var PetaGambar
    //          */
    //         $gambar = PetaGambar::factory()->create();

    //         $user->givePermissionTo(Permission::findOrCreate('update.peta.gambar'));

    //         $this

    //             ->actingAs($user)
    //             ->get(sprintf('/dashboard/peta/gambar/%s/edit', $gambar->getKey()))
    //             ->assertOk()
    //             ->assertInertia(fn (AssertableInertia $page) => $page
    //                 ->component('Dashboard/Peta/Gambar/Edit')
    //                 ->has('gambar', fn (AssertableInertia $assert) => $assert
    //                     ->where('id', $gambar->getKey())
    //                     ->etc()));
    //     }

    //     public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedGambar(): void
    //     {
    //         /**
    //          * @var PetaGambar
    //          */
    //         $gambar = PetaGambar::factory()->create();

    //         $this

    //             ->actingAs(User::factory()->create())
    //             ->get(route('dashboard.peta.gambar.edit', $gambar->getKey(), absolute: true))
    //             ->assertForbidden();
    //     }

    //     public function testCanUpdateSelectedGambar(): void
    //     {
    //         $user = User::factory()->create();

    //         $user->givePermissionTo(Permission::findOrCreate('update.peta.gambar'));

    //         $gambar = PetaGambar::factory()->create();

    //         $newData = [
    //             'nama' => $this->faker->words(3, true),
    //             'keterangan' => $this->faker->words(8, true),
    //         ];

    //         $this

    //             ->actingAs($user)
    //             ->patch(sprintf('/dashboard/peta/gambar/%s', $gambar->getKey()), $newData)
    //             ->assertRedirectToRoute('dashboard.peta.gambar.show', $gambar->getKey());

    //         $this->assertDatabaseHas(PetaGambar::class, [...$newData, 'id' => $gambar->getKey()]);
    //     }

    //     public function testOnlyAuthorizedUserCanUpdateSelectedGambar(): void
    //     {
    //         $user = User::factory()->create();

    //         $gambar = PetaGambar::factory()->create();

    //         $this

    //             ->actingAs($user)
    //             ->patch(sprintf('/dashboard/peta/gambar/%s', $gambar->getKey()))
    //             ->assertForbidden();
    //     }

    //     public function testShowScreenOfSelectedGambarCanBeRendered(): void
    //     {
    //         $user = User::factory()->create();

    //         $user->givePermissionTo(Permission::findOrCreate('view.peta.gambar'));

    //         $gambar = PetaGambar::factory()->create();

    //         $this

    //             ->actingAs($user)
    //             ->get(sprintf('/dashboard/peta/gambar/%s', $gambar->getKey()))
    //             ->assertOk()
    //             ->assertInertia(fn (AssertableInertia $page) => $page
    //                 ->component('Dashboard/Peta/Gambar/Show')
    //                 ->has('gambar', fn (AssertableInertia $renderedGambar) => $renderedGambar
    //                     ->where('id', $gambar->getKey())
    //                     ->etc()));
    //     }

    //     public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedGambar(): void
    //     {
    //         $user = User::factory()->create();

    //         $gambar = PetaGambar::factory()->create();

    //         $this

    //             ->actingAs($user)
    //             ->get(sprintf('/dashboard/peta/gambar/%s', $gambar->getKey()))
    //             ->assertForbidden();
    //     }

    //     public function testCanDestroySelectedGambar(): void
    //     {
    //         $user = User::factory()->create();

    //         $user->givePermissionTo(Permission::findOrCreate('delete.peta.gambar'));

    //         $gambar = PetaGambar::factory()->create();

    //         $this

    //             ->actingAs($user)
    //             ->delete(sprintf('/dashboard/peta/gambar/%s', $gambar->getKey()))
    //             ->assertRedirectToRoute('dashboard.peta.gambar.index');

    //         $this->assertNull($gambar->fresh());
    //     }

    //     public function testOnlyAuthorizedUserCanDestroySelectedGambar(): void
    //     {
    //         $user = User::factory()->create();

    //         $gambar = PetaGambar::factory()->create();

    //         $this

    //             ->actingAs($user)
    //             ->delete(sprintf('/dashboard/peta/gambar/%s', $gambar->getKey()))
    //             ->assertForbidden();
    //     }
}
