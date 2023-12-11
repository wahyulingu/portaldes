<?php

namespace App\Actions\Sid\Surat\Keluar;

use App\Abstractions\Action\Action;
use App\Actions\Sid\Surat\SuratUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Surat\SidSurat;
use App\Models\Sid\Surat\SidSuratKeluar;
use App\Models\Sid\Surat\SidSuratKlasifikasi;
use App\Repositories\Sid\Surat\SidSuratKeluarRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidSurat>
 */
class SuratKeluarUpdateAction extends Action implements RuledActionContract
{
    protected SidSuratKeluar $suratKeluar;

    public function __construct(
        readonly protected SidSuratKeluarRepository $sidSuratKeluarRepository,
        readonly protected SuratUpdateAction $suratUpdateAction,
    ) {
    }

    public function prepare(SidSuratKeluar $surat)
    {
        return tap($this, fn (self $action) => $action->suratKeluar = $surat);
    }

    public function rules(Collection $payload): array
    {
        return [
            'klasifikasi_id' => [
                'sometimes',
                'integer',

                Rule::exists(SidSuratKlasifikasi::class, 'id'),
            ],

            'tujuan' => 'sometimes|string|min:4|max:255',
            'short_desc' => 'sometimes|string',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        $this

            ->suratUpdateAction
            ->prepare($this->suratKeluar->surat)
            ->execute($payload);

        return $this

            ->sidSuratKeluarRepository
            ->update($this->suratKeluar->getKey(), $validatedPayload);
    }
}
