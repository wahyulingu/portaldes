<?php

namespace Tests\Feature\Http\Dashboard\Sid;

use App\Enumerations\Medis\JenisKelamin;
use App\Enumerations\Pendidikan\Pendidikan;
use App\Enumerations\Pendidikan\Tempuh;
use App\Enumerations\Penduduk\Agama;
use App\Enumerations\Penduduk\HubunganKeluarga;
use App\Enumerations\Penduduk\Pekerjaan;
use App\Enumerations\Penduduk\Status;
use App\Enumerations\Penduduk\Status\Ktp;
use App\Enumerations\Penduduk\Status\Perkawinan;
use App\Enumerations\Penduduk\Status\Sosial;
use App\Enumerations\Penduduk\WargaNegara;
use App\Models\Sid\SidKeluarga;
use App\Models\Sid\Penduduk\SidPenduduk;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class KeluargaTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfKeluargaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.keluarga'));

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/keluarga/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Keluarga/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfKeluarga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/keluarga/create')
            ->assertForbidden();
    }

    public function testCanStoreNewKeluarga(): void
    {
        $user = User::factory()->create();
        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.keluarga'));

        $keluarga = [
            'rukun_tetangga_id' => $rukunTetangga->getKey(),
            'alamat' => $this->faker->address,
            'sosial' => Sosial::random()->value,
            'nomor_kartu_keluarga' => strval(mt_rand(1000000000000000, 9999999999999999)),
        ];

        $kepalaKeluarga = [
            'nik' => strval(mt_rand(1000000000000000, 9999999999999999)),
            'nama' => $this->faker->name,
            'ktp' => Ktp::random()->value,
            'hubungan_keluarga' => HubunganKeluarga::random()->value,
            'kelamin' => JenisKelamin::random()->value,
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date,
            'status_penduduk' => Status::random()->value,
            'agama' => Agama::random()->value,
            'pendidikan_kk' => Pendidikan::random()->value,
            'pendidikan_tempuh' => Tempuh::random()->value,
            'pekerjaan' => Pekerjaan::random()->value,
            'kewarganegaraan' => WargaNegara::random()->value,
            'status_kawin' => Perkawinan::random()->value,
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/keluarga', [...$keluarga, ...$kepalaKeluarga])
            ->assertSuccessful();

        $this->assertDatabaseHas(SidKeluarga::class, $keluarga);
        $this->assertDatabaseHas(SidPenduduk::class, [
            'nik' => $kepalaKeluarga['nik'],
            'nomor_kartu_keluarga' => $keluarga['nomor_kartu_keluarga'],
        ]);
    }

    public function testCanStoreNewKeluargaWithExistingPendudukAsKepalaKeluarga(): void
    {
        $user = User::factory()->create();
        $penduduk = SidPenduduk::factory()->create();
        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.keluarga'));

        $keluarga = [
            'rukun_tetangga_id' => $rukunTetangga->getKey(),
            'alamat' => $this->faker->address,
            'sosial' => Sosial::random()->value,
            'nomor_kartu_keluarga' => strval(mt_rand(1000000000000000, 9999999999999999)),
            'nik' => strval($penduduk->nik),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/keluarga', $keluarga)
            ->assertSuccessful();

        unset($keluarga['nik']);
        $this->assertDatabaseHas(SidKeluarga::class, $keluarga);
        $this->assertDatabaseHas(SidPenduduk::class, [
            'nik' => strval($penduduk->nik),
            'nomor_kartu_keluarga' => $keluarga['nomor_kartu_keluarga'],
            'hubungan_keluarga' => HubunganKeluarga::kepala->value]
        );
    }

    public function testOnlyAuthorizedUserCanStoreNewKeluarga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/keluarga')
            ->assertForbidden();
    }

    public function testIndexScreenOfKeluargaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.keluarga'));

        SidKeluarga::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/keluarga')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Keluarga/Index')
                ->has('keluarga', fn (AssertableInertia $keluarga) => $keluarga
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testKeluargaCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.keluarga'));

        /**
         * @var SidKeluarga
         */
        $keluarga = SidKeluarga::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/keluarga?keyword=%s', substr($keluarga->nama, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Keluarga/Index')
                ->has('keluarga', fn (AssertableInertia $keluarga) => $keluarga
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfKeluarga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/keluarga')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedKeluargaCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidKeluarga
         */
        $keluarga = SidKeluarga::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.keluarga'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/keluarga/%s/edit', $keluarga->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Keluarga/Edit')
                ->has('keluarga', fn (AssertableInertia $data) => $data
                    ->where($keluarga->getKeyName(), $keluarga->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedKeluarga(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/keluarga')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedKeluarga(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.keluarga'));

        $keluarga = SidKeluarga::factory()->create();

        $newData = ['alamat' => $this->faker->address];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/keluarga/%s', $keluarga->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.keluarga.show', $keluarga->getKey());

        $this->assertDatabaseHas(SidKeluarga::class, [...$newData, $keluarga->getKeyName() => $keluarga->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedKeluarga(): void
    {
        $user = User::factory()->create();

        $keluarga = SidKeluarga::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/keluarga/%s', $keluarga->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedKeluargaCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.keluarga'));

        $keluarga = SidKeluarga::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/keluarga/%s', $keluarga->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Keluarga/Show')
                ->has('keluarga', fn (AssertableInertia $renderedKeluarga) => $renderedKeluarga
                    ->where($keluarga->getKeyName(), $keluarga->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedKeluarga(): void
    {
        $user = User::factory()->create();

        $keluarga = SidKeluarga::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/keluarga/%s', $keluarga->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedKeluarga(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.keluarga'));

        $keluarga = SidKeluarga::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/keluarga/%s', $keluarga->getKey()))
            ->assertRedirectToRoute('dashboard.sid.keluarga.index');

        $this->assertNull($keluarga->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedKeluarga(): void
    {
        $user = User::factory()->create();

        $keluarga = SidKeluarga::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/keluarga/%s', $keluarga->getKey()))
            ->assertForbidden();
    }
}
