<?php

namespace Tests\Feature\Http\Dashboard\Sid;

use App\Enumerations\Medis\JenisKelamin;
use App\Enumerations\Pendidikan\Pendidikan;
use App\Enumerations\Penduduk\Agama;
use App\Models\Sid\Pamong\SidPamong;
use App\Models\Sid\Pamong\SidPamongProfile;
use App\Models\Sid\Penduduk\SidPenduduk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PamongTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfPamongCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.pamong'));

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/pamong/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Pamong/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfPamong(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/pamong/create')
            ->assertForbidden();
    }

    public function testCanStoreNewPamong(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.pamong'));

        $pamong = [
            'nipd' => strval(mt_rand(1000000, 9999999)),
            'nik' => strval(mt_rand(1000000000000000, 9999999999999999)),
            'jabatan' => $this->faker->word,
            'golongan' => $this->faker->word,
            'tupoksi' => $this->faker->word,
            'tgl_pengangkatan' => $this->faker->date,
            'profile_type' => SidPamongProfile::class,
        ];

        $profilePamong = [
            'telepon' => $this->faker->phoneNumber,
            'alamat_sekarang' => $this->faker->address,
            'nama' => $this->faker->name,
            'tempat_lahir' => $this->faker->city,
            'email' => $this->faker->email,
            'kelamin' => JenisKelamin::random()->value,
            'pendidikan_kk' => Pendidikan::random()->value,
            'agama' => Agama::random()->value,
            'tgl_lahir' => $this->faker->date,
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/pamong', [...$pamong, ...$profilePamong])
            ->assertSuccessful();

        $this->assertDatabaseHas(SidPamong::class, $pamong);
        $this->assertDatabaseHas(SidPamongProfile::class, [
            'nipd' => $pamong['nipd'],
            'nama' => $profilePamong['nama'],
        ]);
    }

    public function testCanStoreNewPamongWithExistingPendudukAsPamong(): void
    {
        $user = User::factory()->create();
        $penduduk = SidPenduduk::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.pamong'));

        $pamong = [
            'nipd' => strval(mt_rand(1000000, 9999999)),
            'nik' => strval($penduduk->nik),
            'jabatan' => $this->faker->word,
            'golongan' => $this->faker->word,
            'tupoksi' => $this->faker->word,
            'tgl_pengangkatan' => $this->faker->date,
            'profile_type' => SidPenduduk::class,
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/pamong', $pamong)
            ->assertSuccessful();

        $this->assertDatabaseHas(SidPamong::class, $pamong);
    }

    public function testOnlyAuthorizedUserCanStoreNewPamong(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/pamong')
            ->assertForbidden();
    }

    public function testIndexScreenOfPamongCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.pamong'));

        SidPamong::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/pamong')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Pamong/Index')
                ->has('pamong', fn (AssertableInertia $pamong) => $pamong
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testPamongCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.pamong'));

        /**
         * @var SidPamong
         */
        $pamong = SidPamong::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/pamong?keyword=%s', substr($pamong->nama, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Pamong/Index')
                ->has('pamong', fn (AssertableInertia $pamong) => $pamong
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfPamong(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/pamong')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedPamongCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidPamong
         */
        $pamong = SidPamong::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.pamong'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/pamong/%s/edit', $pamong->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Pamong/Edit')
                ->has('pamong', fn (AssertableInertia $data) => $data
                    ->where($pamong->getKeyName(), $pamong->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedPamong(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/pamong')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedPamong(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.pamong'));

        $pamong = SidPamong::factory()->create();

        $newData = [
            'alamat_sekarang' => $this->faker->address,
            'nama' => $this->faker->name,
            'jabatan' => $this->faker->word,
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/pamong/%s', $pamong->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.pamong.show', $pamong->getKey());

        $freshPamong = $pamong->fresh();
        $freshProfile = $pamong->profile->fresh();

        $this->assertInstanceOf(SidPamongProfile::class, $pamong->profile);
        $this->assertEquals($newData['jabatan'], $freshPamong->jabatan);
        $this->assertEquals($newData['nama'], $freshProfile->nama);
        $this->assertEquals($newData['alamat_sekarang'], $freshProfile->alamat_sekarang);
    }

    public function testCanUpdatePamongFromPenduduk(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.pamong'));

        $pamong = SidPamong::factory()->fromPenduduk()->create();

        $newData = [
            'alamat_sekarang' => $this->faker->address,
            'nama' => $this->faker->name,
            'jabatan' => $this->faker->word,
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/pamong/%s', $pamong->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.sid.pamong.show', $pamong->getKey());

        $freshPamong = $pamong->fresh();
        $freshProfile = $pamong->profile->fresh();

        $this->assertInstanceOf(SidPenduduk::class, $pamong->profile);
        $this->assertEquals($newData['jabatan'], $freshPamong->jabatan);
        $this->assertEquals($newData['nama'], $freshProfile->nama);
        $this->assertEquals($newData['alamat_sekarang'], $freshProfile->alamat_sekarang);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedPamong(): void
    {
        $user = User::factory()->create();

        $pamong = SidPamong::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/pamong/%s', $pamong->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedPamongCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.pamong'));

        $pamong = SidPamong::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/pamong/%s', $pamong->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Pamong/Show')
                ->has('pamong', fn (AssertableInertia $renderedPamong) => $renderedPamong
                    ->where($pamong->getKeyName(), $pamong->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedPamong(): void
    {
        $user = User::factory()->create();

        $pamong = SidPamong::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/pamong/%s', $pamong->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedPamong(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.pamong'));

        $pamong = SidPamong::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/pamong/%s', $pamong->getKey()))
            ->assertRedirectToRoute('dashboard.sid.pamong.index');

        $this->assertNull($pamong->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedPamong(): void
    {
        $user = User::factory()->create();

        $pamong = SidPamong::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/pamong/%s', $pamong->getKey()))
            ->assertForbidden();
    }
}
