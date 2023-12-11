<?php

namespace App\Actions\Sid\Surat;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Surat\SidSurat;
use App\Repositories\Sid\Surat\SidSuratRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidSurat>
 */
class SuratUpdateAction extends Action implements RuledActionContract
{
    protected SidSurat $surat;

    public function __construct(
        readonly protected SidSuratRepository $sidSuratRepository
    ) {
    }

    public function prepare(SidSurat $surat)
    {
        return tap($this, fn (self $action) => $action->surat = $surat);
    }

    public function rules(Collection $payload): array
    {
        return [
            'nomor_surat' => [
                'sometimes',
                'string',
                'min:4',
                'max:8',

                Rule::unique(SidSurat::class),
            ],

            'nomor_urut' => 'sometimes|numeric',
            'tanggal_surat' => 'sometimes|date',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->sidSuratRepository->update($this->surat->getKey(), $validatedPayload);
    }
}
