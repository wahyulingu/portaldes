<?php

namespace Tests\Feature\Http\Dashboard\Peta\Area;

use App\Models\Peta\PetaArea;
use App\Models\Peta\PetaKategori;
use App\Models\User;
use App\Repositories\FileRepository;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AreaTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfAreaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.area'));

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/area/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Area/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfArea(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/peta/area/create')
            ->assertForbidden();
    }

    public function testCanStoreNewArea(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.peta.area'));

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $gambar = UploadedFile::fake()->image('area.png');

        $area = [
            'kategori_id' => PetaKategori::factory()->area()->create()->getKey(),
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
            'path' => [[[]]],
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/peta/area', [...$area, ...compact('gambar')])
            ->assertRedirectToRoute('dashboard.peta.area.index');

        $fakeStorage->assertExists($gambar->hashName('peta/gambar'));

        $area['path'] = json_encode($area['path']);

        $this->assertDatabaseHas(PetaArea::class, $area);
    }

    public function testOnlyAuthorizedUserCanStoreNewArea(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/peta/area')
            ->assertForbidden();
    }

    public function testIndexScreenOfAreaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.area'));

        PetaArea::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/peta/area')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Area/Index')
                ->has('area', fn (AssertableInertia $area) => $area
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testAreaCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.peta.area'));

        /**
         * @var PetaArea
         */
        $area = PetaArea::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/area?keyword=%s', substr($area->keterangan, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Area/Index')
                ->has('area', fn (AssertableInertia $area) => $area
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfArea(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.area.index', absolute: true))
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedAreaCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var PetaArea
         */
        $area = PetaArea::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.area'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/area/%s/edit', $area->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Area/Edit')
                ->has('area', fn (AssertableInertia $assert) => $assert
                    ->where('id', $area->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedArea(): void
    {
        /**
         * @var PetaArea
         */
        $area = PetaArea::factory()->create();

        $this

            ->actingAs(User::factory()->create())
            ->get(route('dashboard.peta.area.edit', $area->getKey(), absolute: true))
            ->assertForbidden();
    }

    public function testCanUpdateSelectedArea(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.peta.area'));

        $area = PetaArea::factory()->create();

        $newData = [
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/area/%s', $area->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.peta.area.show', $area->getKey());

        $this->assertDatabaseHas(PetaArea::class, [...$newData, 'id' => $area->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedArea(): void
    {
        $user = User::factory()->create();

        $area = PetaArea::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/peta/area/%s', $area->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedAreaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.peta.area'));

        $area = PetaArea::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/area/%s', $area->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Peta/Area/Show')
                ->has('area', fn (AssertableInertia $renderedArea) => $renderedArea
                    ->where('id', $area->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedArea(): void
    {
        $user = User::factory()->create();

        $area = PetaArea::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/peta/area/%s', $area->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedArea(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.peta.area'));

        $area = PetaArea::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/area/%s', $area->getKey()))
            ->assertRedirectToRoute('dashboard.peta.area.index');

        $this->assertNull($area->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedArea(): void
    {
        $user = User::factory()->create();

        $area = PetaArea::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/peta/area/%s', $area->getKey()))
            ->assertForbidden();
    }
}
