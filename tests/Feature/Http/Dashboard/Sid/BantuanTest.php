<?php

namespace Tests\Feature\Http\Dashboard\Sid;

use App\Enumerations\Medis\JenisKelamin;
use App\Enumerations\Pendidikan\Pendidikan;
use App\Enumerations\Pendidikan\Tempuh;
use App\Enumerations\Penduduk\Agama;
use App\Enumerations\Penduduk\Pekerjaan;
use App\Enumerations\Penduduk\Status;
use App\Enumerations\Penduduk\Status\Ktp;
use App\Enumerations\Penduduk\Status\Perkawinan;
use App\Enumerations\Penduduk\Status\Sosial;
use App\Enumerations\Penduduk\WargaNegara;
use App\Models\Sid\SidBantuan;
use App\Models\Sid\SidPenduduk;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class BantuanTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfBantuanCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.bantuan'));

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/bantuan/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Bantuan/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfBantuan(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/bantuan/create')
            ->assertForbidden();
    }

    public function testCanStoreNewBantuan(): void
    {
        $user = User::factory()->create();
        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.bantuan'));

        $bantuan = [
            'rukun_tetangga_id' => $rukunTetangga->getKey(),
            'alamat' => $this->faker->address,
            'sosial' => Sosial::random()->value,
            'nomor_kartu_bantuan' => strval(mt_rand(1000000000000000, 9999999999999999)),
        ];

        $kepalaBantuan = [
            'nik' => strval(mt_rand(1000000000000000, 9999999999999999)),
            'nama' => $this->faker->name,
            'ktp' => Ktp::random()->value,
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
            ->post('/dashboard/sid/bantuan', [...$bantuan, ...$kepalaBantuan])
            ->assertSuccessful();

        $this->assertDatabaseHas(SidBantuan::class, $bantuan);
        $this->assertDatabaseHas(SidPenduduk::class, [
            'nik' => $kepalaBantuan['nik'],
            'nomor_kartu_bantuan' => $bantuan['nomor_kartu_bantuan'],
        ]);
    }

    public function testCanStoreNewBantuanWithExistingPendudukAsKepalaBantuan(): void
    {
        $user = User::factory()->create();
        $penduduk = SidPenduduk::factory()->create();
        $rukunTetangga = SidWilayahRukunTetangga::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.bantuan'));

        $bantuan = [
            'rukun_tetangga_id' => $rukunTetangga->getKey(),
            'alamat' => $this->faker->address,
            'sosial' => Sosial::random()->value,
            'nomor_kartu_bantuan' => strval(mt_rand(1000000000000000, 9999999999999999)),
            'nik' => strval($penduduk->nik),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/bantuan', $bantuan)
            ->assertSuccessful();

        unset($bantuan['nik']);
        $this->assertDatabaseHas(SidBantuan::class, $bantuan);
        $this->assertDatabaseHas(SidPenduduk::class, [
            'nik' => strval($penduduk->nik),
            'nomor_kartu_bantuan' => $bantuan['nomor_kartu_bantuan'],
            ]
        );
    }

    public function testOnlyAuthorizedUserCanStoreNewBantuan(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/bantuan')
            ->assertForbidden();
    }

    public function testIndexScreenOfBantuanCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.bantuan'));

        SidBantuan::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/bantuan')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Bantuan/Index')
                ->has('bantuan', fn (AssertableInertia $bantuan) => $bantuan
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testBantuanCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.bantuan'));

        /**
         * @var SidBantuan
         */
        $bantuan = SidBantuan::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/bantuan?keyword=%s', substr($bantuan->nama, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Bantuan/Index')
                ->has('bantuan', fn (AssertableInertia $bantuan) => $bantuan
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfBantuan(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/bantuan')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedBantuanCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidBantuan
         */
        $bantuan = SidBantuan::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.bantuan'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/bantuan/%s/edit', $bantuan->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Bantuan/Edit')
                ->has('bantuan', fn (AssertableInertia $data) => $data
                    ->where($bantuan->getKeyName(), $bantuan->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedBantuan(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/bantuan')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedBantuan(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.bantuan'));

        $bantuan = SidBantuan::factory()->create();

        $newData = ['alamat' => $this->faker->address];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/bantuan/%s', $bantuan->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.bantuan.show', $bantuan->getKey());

        $this->assertDatabaseHas(SidBantuan::class, [...$newData, $bantuan->getKeyName() => $bantuan->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedBantuan(): void
    {
        $user = User::factory()->create();

        $bantuan = SidBantuan::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/bantuan/%s', $bantuan->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedBantuanCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.bantuan'));

        $bantuan = SidBantuan::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/bantuan/%s', $bantuan->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Bantuan/Show')
                ->has('bantuan', fn (AssertableInertia $renderedBantuan) => $renderedBantuan
                    ->where($bantuan->getKeyName(), $bantuan->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedBantuan(): void
    {
        $user = User::factory()->create();

        $bantuan = SidBantuan::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/bantuan/%s', $bantuan->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedBantuan(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.bantuan'));

        $bantuan = SidBantuan::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/bantuan/%s', $bantuan->getKey()))
            ->assertRedirectToRoute('dashboard.sid.bantuan.index');

        $this->assertNull($bantuan->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedBantuan(): void
    {
        $user = User::factory()->create();

        $bantuan = SidBantuan::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/bantuan/%s', $bantuan->getKey()))
            ->assertForbidden();
    }
}
