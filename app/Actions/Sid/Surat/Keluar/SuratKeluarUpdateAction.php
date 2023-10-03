<?php

namespace App\Actions\Sid\Surat\Keluar;

use App\Abstractions\Action\Action;
use App\Actions\Sid\Surat\SuratUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Surat\SidSurat;
use App\Models\Sid\Surat\SidSuratKlasifikasi;
use App\Repositories\Sid\Surat\SidSuratKeluarRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidSurat>
 */
class SuratKeluarUpdateAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected SidSuratKeluarRepository $sidSuratKeluarRepository,
        readonly protected SuratUpdateAction $suratUpdateAction,
    ) {
    }

    public function rules(array $payload): array
    {
        return [
            'klasifikasi_id' => [
                'required',
                'integer',

                Rule::exists(SidSuratKlasifikasi::class, 'id'),
            ],

            'tujuan' => 'required|string|min:4|max:255',
            'short_desc' => 'required|string',
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return DB::transaction(
            fn () => tap(
                $this->sidSuratKeluarRepository->store($validatedPayload),

                fn () => $this->suratUpdateAction->execute($payload)
            )
        );
    }
}
