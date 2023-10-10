<?php

namespace Tests\Feature\Http\Dashboard\Sid\Surat;

use App\Models\Sid\Pamong\SidPamong;
use App\Models\Sid\Surat\SidSurat;
use App\Models\Sid\Surat\SidSuratKeluar;
use App\Models\Sid\Surat\SidSuratKlasifikasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SuratKeluarTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfSuratKeluarCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.surat.surat-keluar'));

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/surat/surat-keluar/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Surat/Keluar/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfSuratKeluar(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/surat/surat-keluar/create')
            ->assertForbidden();
    }

    public function testCanStoreNewSuratKeluar(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.sid.surat.surat-keluar'));

        $suratKeluar = [
            'klasifikasi_id' => SidSuratKlasifikasi::factory()->create()->getKey(),
            'tujuan' => $this->faker->company,
            'short_desc' => $this->faker->paragraph,
        ];

        $suratMaster = [
            'pamong_id' => SidPamong::factory()->create()->getKey(),
            'nomor_surat' => Str::random(8),
            'tanggal' => now()->addDays(mt_rand(1, 8)),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/sid/surat/surat-keluar', [
                ...$suratKeluar,
                ...$suratMaster,
            ])

            ->assertSuccessful();

        $this->assertDatabaseHas(SidSurat::class, $suratMaster);
        $this->assertDatabaseHas(SidSuratKeluar::class, $suratKeluar);
    }

    public function testOnlyAuthorizedUserCanStoreNewSuratKeluar(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/sid/surat/surat-keluar')
            ->assertForbidden();
    }

    public function testIndexScreenOfSuratKeluarCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.surat.surat-keluar'));

        SidSurat::factory(5)->suratKeluar()->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/surat/surat-keluar')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Surat/Keluar/Index')
                ->has('surat', fn (AssertableInertia $suratKeluar) => $suratKeluar
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testSuratKeluarCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.surat.surat-keluar'));

        /**
         * @var SidSuratKeluar
         */
        $suratKeluar = SidSurat::factory()->suratKeluar()->create()->surat;

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/surat/surat-keluar?keyword=%s', substr($suratKeluar->nama, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Surat/Keluar/Index')
                ->has('surat', fn (AssertableInertia $suratKeluar) => $suratKeluar
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfSuratKeluar(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/surat/surat-keluar')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedSuratKeluarCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var SidSuratKeluar
         */
        $suratKeluar = SidSuratKeluar::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.surat.surat-keluar'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/surat/surat-keluar/%s/edit', $suratKeluar->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Surat/Keluar/Edit')
                ->has('surat_keluar', fn (AssertableInertia $data) => $data
                    ->where($suratKeluar->getKeyName(), $suratKeluar->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedSuratKeluar(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/surat/surat-keluar')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedSuratKeluar(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.sid.surat.surat-keluar'));

        $suratMaster = SidSurat::factory()->suratKeluar()->create();
        $suratKeluar = $suratMaster->surat;

        $suratKeluarNewData = ['tujuan' => $this->faker->company];
        $suratMaseterNewData = ['nomor_surat' => Str::random(8)];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/surat/surat-keluar/%s', $suratKeluar->getKey()), [
                ...$suratKeluarNewData,
                ...$suratMaseterNewData,
            ])

            ->assertRedirectToRoute('dashboard.sid.surat.surat-keluar.show', $suratKeluar->getKey());

        $this->assertDatabaseHas(SidSuratKeluar::class, [
            ...$suratKeluarNewData,
            $suratKeluar->getKeyName() => $suratKeluar->getKey(),
        ]);

        $this->assertDatabaseHas(SidSurat::class, [
            ...$suratMaseterNewData,
            $suratMaster->getKeyName() => $suratMaster->getKey(),
        ]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedSuratKeluar(): void
    {
        $user = User::factory()->create();

        $suratKeluar = SidSuratKeluar::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/sid/surat/surat-keluar/%s', $suratKeluar->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedSuratKeluarCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.sid.surat.surat-keluar'));

        $suratKeluar = SidSurat::factory()->suratKeluar()->create()->surat;

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/surat/surat-keluar/%s', $suratKeluar->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Surat/Keluar/Show')
                ->has('surat_keluar', fn (AssertableInertia $renderedSuratKeluar) => $renderedSuratKeluar
                    ->where($suratKeluar->getKeyName(), $suratKeluar->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedSuratKeluar(): void
    {
        $user = User::factory()->create();

        $suratKeluar = SidSurat::factory()->suratKeluar()->create()->surat;

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/surat/surat-keluar/%s', $suratKeluar->getKey()))
            ->assertForbidden();
    }
}
