<?php

namespace App\Actions\Sid\Surat;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Surat\SidSurat;
use App\Models\Sid\Surat\SidSuratKeluar;
use App\Models\Sid\Surat\SidSuratMasuk;
use App\Models\Sid\Surat\SidSuratWarga;
use App\Repositories\Sid\Surat\SidSuratRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidSurat>
 */
class SuratStoreAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected SidSuratRepository $sidSuratRepository
    ) {
    }

    public function rules(array $payload): array
    {
        $suratTypes = [
            SidSuratMasuk::class,
            SidSuratWarga::class,
            SidSuratKeluar::class,
        ];

        return [
            'pamong_id' => [
                'required',
                'integer',

                Rule::exists(SidSurat::class, 'id'),
            ],

            'surat_type' => ['required', Rule::in($suratTypes)],

            'surat_id' => [
                'required',
                'integer',

                Rule::exists(@$payload['surat_type'], 'id')->when(
                    fn () => in_array(@$payload['surat_type'], $suratTypes)
                ),
            ],

            'nomor_surat' => [
                'required',
                'string',
                'min:4',
                'max:8',

                Rule::unique(SidSurat::class),
            ],

            'nomor_urut' => 'nullable|numeric',
            'tanggal_surat' => 'rquired|date',
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->sidSuratRepository->store($validatedPayload);
    }
}
