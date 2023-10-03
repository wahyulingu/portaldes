<?php

namespace Tests\Feature\Http\Dashboard\Sid\Surat;

use App\Models\Sid\Surat\SidSurat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SuratTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndexScreenOfSuratCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.surat'));

        SidSurat::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/sid/surat')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Surat/Index')
                ->has('surat', fn (AssertableInertia $surat) => $surat
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testSuratCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.sid.surat'));

        /**
         * @var SidSurat
         */
        $surat = SidSurat::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/sid/surat?keyword=%s', substr($surat->nama, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Sid/Surat/Index')
                ->has('surat', fn (AssertableInertia $surat) => $surat
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfSurat(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/sid/surat')
            ->assertForbidden();
    }

    public function testCanDestroySelectedSurat(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.sid.surat'));

        $surat = SidSurat::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/surat/%s', $surat->getKey()))
            ->assertRedirectToRoute('dashboard.sid.surat.index');

        $this->assertNull($surat->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedSurat(): void
    {
        $user = User::factory()->create();

        $surat = SidSurat::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/sid/surat/%s', $surat->getKey()))
            ->assertForbidden();
    }
}
