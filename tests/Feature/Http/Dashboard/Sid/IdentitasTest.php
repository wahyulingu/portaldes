<?php

namespace Tests\Feature\Http\Dashboard\Sid;

use App\Models\User;
use App\Repositories\FileRepository;
use App\Repositories\Media\MediaPictureRepository;
use App\Repositories\MetaRepository;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IdentitasTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testEditScreenOfIdentitasCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.identitas'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/identitas/edit'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Identitas/Edit')
                ->has('identitas', fn (AssertableInertia $data) => $data
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfIdentitas(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/identitas')
            ->assertForbidden();
    }

    public function testCanUpdateIdentitas(): void
    {
        $user = User::factory()->create();

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $logo = UploadedFile::fake()->image('logo.png');
        $stamp = UploadedFile::fake()->image('stamp.png');

        $user->givePermissionTo(Permission::findOrCreate('update.sid.identitas'));

        $data = [
            'nama_desa' => $this->faker->city,
            'alamat' => $this->faker->address,
            'lat' => $this->faker->latitude,
            'long' => $this->faker->longitude,
            'telepon' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'website' => $this->faker->domainName,
            'kode_desa' => $this->faker->randomDigitNotNull,
            'kodepos' => $this->faker->randomDigitNotNull,
            'nama_kecamatan' => $this->faker->city,
            'kode_kecamatan' => $this->faker->randomDigitNotNull,
            'nama_kabupaten' => $this->faker->city,
            'kode_kabupaten' => $this->faker->randomDigitNotNull,
            'nama_kades' => $this->faker->name,
            'nama_camat' => $this->faker->name,
            'nama_bupati' => $this->faker->name,
            'nama_provinsi' => $this->faker->city,
            'nama_gubernur' => $this->faker->name,
            'kode_provinsi' => $this->faker->randomDigitNotNull,
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/identitas'), [...$data, ...compact('logo', 'stamp')])
            ->assertRedirectToRoute('dashboard.sid.identitas.show');

        $actualIdentitas = app(MetaRepository::class)->findBySlug('sid-identitas')->fresh();

        /**
         * @var MediaPictureRepository
         */
        $pictureRepository = app(MediaPictureRepository::class);

        $fakeStorage->assertExists($logo->hashName('media/picture/sid'));
        $fakeStorage->assertExists($stamp->hashName('media/picture/sid'));

        $logoModel = $pictureRepository->find($actualIdentitas->value['logo']);
        $stampModel = $pictureRepository->find($actualIdentitas->value['stamp']);

        $this->assertEquals(
            expected: $logo->hashName('media/picture/sid'),
            actual: $logoModel->file->path
        );

        $this->assertEquals(
            expected: $stamp->hashName('media/picture/sid'),
            actual: $stampModel->file->path
        );

        $this->assertNotNull($actualIdentitas);
        $this->assertEquals(
            [
                ...$data,

                'logo' => $logoModel->getKey(),
                'stamp' => $stampModel->getKey(),
            ],

            $actualIdentitas->value
        );
    }

    public function testOnlyAuthorizedUserCanUpdateIdentitas(): void
    {
        $user = User::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/identitas'))
            ->assertForbidden();
    }

    public function testShowScreenOfIdentitasCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.identitas'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/identitas'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Identitas/Show')
                ->has('identitas', fn (AssertableInertia $renderedIdentitas) => $renderedIdentitas
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfIdentitas(): void
    {
        $user = User::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/identitas'))
            ->assertForbidden();
    }
}
