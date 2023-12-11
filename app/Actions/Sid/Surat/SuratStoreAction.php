<?php

namespace App\Actions\Sid\Surat;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Pamong\SidPamong;
use App\Models\Sid\Surat\SidSurat;
use App\Models\Sid\Surat\SidSuratKeluar;
use App\Models\Sid\Surat\SidSuratMasuk;
use App\Models\Sid\Surat\SidSuratWarga;
use App\Repositories\Sid\Surat\SidSuratRepository;
use Illuminate\Support\Collection;
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

    public function rules(Collection $payload): array
    {
        $suratTypes = [
            SidSuratMasuk::class,
            SidSuratWarga::class,
            SidSuratKeluar::class,
        ];

        $rules = [
            'pamong_id' => [
                'required',
                'integer',

                Rule::exists(SidPamong::class, 'id'),
            ],

            'surat_type' => ['required', Rule::in($suratTypes)],

            'nomor_surat' => [
                'required',
                'string',
                'min:4',
                'max:8',

                Rule::unique(SidSurat::class),
            ],

            'nomor_urut' => 'nullable|numeric',
            'tanggal' => 'required|date',
        ];

        if (in_array(@$payload['surat_type'], $suratTypes)) {
            return [
                ...$rules,

                'surat_id' => [
                    'required',
                    'integer',

                    Rule::exists(@$payload['surat_type'], 'id'),
                ],
            ];
        }

        return $rules;
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->sidSuratRepository->store($validatedPayload);
    }
}
