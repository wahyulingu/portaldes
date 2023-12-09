<?php

namespace Tests\Feature\Action\Sid;

use App\Actions\Sid\Penduduk\Index\PendudukIndexAction;
use App\Actions\Sid\Penduduk\Index\PendudukIndexByKeywordAction;
use App\Actions\Sid\Penduduk\PendudukDeleteAction;
use App\Actions\Sid\Penduduk\PendudukStoreAction;
use App\Actions\Sid\Penduduk\PendudukUpdateAction;
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
use App\Models\Sid\SidPenduduk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PendudukActionTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testCanStoreNewPenduduk(): void
    {
        /**
         * @var PendudukStoreAction
         */
        $action = app(PendudukStoreAction::class);

        $penduduk = [
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

        $action->execute($penduduk);

        $this->assertDatabaseHas(SidPenduduk::class, $penduduk);
    }

    public function testCanUpdateExistingPenduduk(): void
    {
        // /**
        //  * @var SidPenduduk
        //  */
        // $category = SidPenduduk::factory()->create();

        // /**
        //  * @var PendudukUpdateAction
        //  */
        // $action = app(PendudukUpdateAction::class);

        // $contentData = [
        //     'name' => ucfirst($this->faker->words(8, true)),
        //     'description' => ucfirst($this->faker->words(8, true)),
        //     'parent_id' => SidPenduduk::factory()->create()->getKey(),
        // ];

        // $action->prepare($category)->execute($contentData);

        // $this->assertDatabaseHas('content_categories', [...$contentData, 'id' => $category->getKey()]);
    }

    public function testCanDeleteExistingPenduduk(): void
    {
        /**
         * @var SidPenduduk
         */
        $category = SidPenduduk::factory()->create();

        /**
         * @var PendudukDeleteAction
         */
        $deleteAction = app(PendudukDeleteAction::class);

        $deleteAction->prepare($category)->execute();

        $this->assertNull($category->fresh());
    }

    public function testPendudukCanIndex()
    {
        /**
         * @var PendudukIndexAction
         */
        $action = app(PendudukIndexAction::class);

        /**
         * @var SidPenduduk
         */
        $category = SidPenduduk::factory()->create();

        $this->assertGreaterThan(0, $action->execute()->count());
    }

    public function testPendudukCanIndexByKeyword()
    {
        /**
         * @var PendudukIndexByKeywordAction
         */
        $action = app(PendudukIndexByKeywordAction::class);

        /**
         * @var SidPenduduk
         */
        $category = SidPenduduk::factory()->create();

        $this->assertGreaterThan(0, $action->execute(['keyword' => substr($category->description, 8, 24)])->count());
    }
}
