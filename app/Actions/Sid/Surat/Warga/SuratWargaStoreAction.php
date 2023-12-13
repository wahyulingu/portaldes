<?php

namespace App\Actions\Sid\Surat\Warga;

use App\Abstractions\Action\Action;
use App\Actions\Sid\Surat\SuratStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Sid\SidPenduduk;
use App\Models\Sid\Surat\SidSurat;
use App\Models\Sid\Surat\SidSuratWarga;
use App\Repositories\Sid\Surat\SidSuratWargaRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidSurat>
 */
class SuratWargaStoreAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected SidSuratWargaRepository $sidSuratWargaRepository,
        readonly protected SuratStoreAction $suratStoreAction,
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'penduduk_id' => [
                'required',
                'integer',

                Rule::exists(SidPenduduk::class, 'id'),
            ],

            'payload' => 'required|array',
            'status' => ['required', 'string', Rule::enum(Moderation::class)],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return DB::transaction(
            fn () => tap(
                $this->sidSuratWargaRepository->store($validatedPayload),

                fn (SidSuratWarga $surat) => $this->suratStoreAction->execute([
                    ...$payload,

                    'surat_type' => $surat::class,
                    'surat_id' => $surat->getKey(),
                ])
            )
        );
    }
}
