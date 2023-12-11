<?php

namespace App\Actions\Sid\Surat\Masuk;

use App\Abstractions\Action\Action;
use App\Actions\Sid\Surat\SuratStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Surat\SidSurat;
use App\Models\Sid\Surat\SidSuratKlasifikasi;
use App\Models\Sid\Surat\SidSuratMasuk;
use App\Repositories\Sid\Surat\SidSuratMasukRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidSurat>
 */
class SuratMasukStoreAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected SidSuratMasukRepository $sidSuratMasukRepository,
        readonly protected SuratStoreAction $suratStoreAction,
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'klasifikasi_id' => [
                'required',
                'integer',

                Rule::exists(SidSuratKlasifikasi::class, 'id'),
            ],

            'pengirim' => 'required|string|min:4|max:255',
            'perihal' => 'required|string|min:4|max:255',
            'disposisi' => 'required|string',
            'short_desc' => 'required|string',

            'tanggal_penerimaan' => 'required|date',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return DB::transaction(
            fn () => tap(
                $this->sidSuratMasukRepository->store($validatedPayload),

                fn (SidSuratMasuk $surat) => $this->suratStoreAction->execute([
                    ...$payload,

                    'surat_type' => $surat::class,
                    'surat_id' => $surat->getKey(),
                ])
            )
        );
    }
}
