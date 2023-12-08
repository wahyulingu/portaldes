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
use App\Enumerations\Penduduk\WargaNegara;
use App\Models\Sid\Penduduk\SidPenduduk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PendudukTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfPendudukCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.penduduk'));

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/penduduk/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Penduduk/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfPenduduk(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/penduduk/create')
            ->assertForbidden();
    }

    public function testCanStoreNewPenduduk(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.penduduk'));

        $penduduk = [
            'nik' => strval(mt_rand(1000000000000000, 9999999999999999)),
            'nomor_kartu_keluarga' => strval(mt_rand(1000000000000000, 9999999999999999)),
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
            ->post('/dashboard/sid/penduduk', $penduduk)
            ->assertSuccessful();

        $this->assertDatabaseHas(SidPenduduk::class, $penduduk);
    }

    public function testOnlyAuthorizedUserCanStoreNewPendudukOrSubpenduduk(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/penduduk')
            ->assertForbidden();
    }

    public function testIndexScreenOfPendudukCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.penduduk'));

        SidPenduduk::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/penduduk')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Penduduk/Index')
                ->has('penduduk', fn (AssertableInertia $penduduk) => $penduduk
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testPendudukCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.penduduk'));

        /**
         * @var SidPenduduk
         */
        $penduduk = SidPenduduk::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/penduduk?keyword=%s', substr($penduduk->nama, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Penduduk/Index')
                ->has('penduduk', fn (AssertableInertia $penduduk) => $penduduk
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfPenduduk(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/penduduk')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedPendudukCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidPenduduk
         */
        $penduduk = SidPenduduk::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.penduduk'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/penduduk/%s/edit', $penduduk->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Penduduk/Edit')
                ->has('penduduk', fn (AssertableInertia $data) => $data
                    ->where($penduduk->getKeyName(), $penduduk->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedPenduduk(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/penduduk')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedPenduduk(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.penduduk'));

        $penduduk = SidPenduduk::factory()->create();

        $newData = ['nama' => $this->faker->name];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/penduduk/%s', $penduduk->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.penduduk.show', $penduduk->getKey());

        $this->assertDatabaseHas(SidPenduduk::class, [...$newData, $penduduk->getKeyName() => $penduduk->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedPenduduk(): void
    {
        $user = User::factory()->create();

        $penduduk = SidPenduduk::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/penduduk/%s', $penduduk->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedPendudukCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.penduduk'));

        $penduduk = SidPenduduk::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/penduduk/%s', $penduduk->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Penduduk/Show')
                ->has('penduduk', fn (AssertableInertia $renderedPenduduk) => $renderedPenduduk
                    ->where($penduduk->getKeyName(), $penduduk->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedPenduduk(): void
    {
        $user = User::factory()->create();

        $penduduk = SidPenduduk::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/penduduk/%s', $penduduk->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedPenduduk(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.penduduk'));

        $penduduk = SidPenduduk::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/penduduk/%s', $penduduk->getKey()))
            ->assertRedirectToRoute('dashboard.sid.penduduk.index');

        $this->assertNull($penduduk->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedPenduduk(): void
    {
        $user = User::factory()->create();

        $penduduk = SidPenduduk::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/penduduk/%s', $penduduk->getKey()))
            ->assertForbidden();
    }
}
