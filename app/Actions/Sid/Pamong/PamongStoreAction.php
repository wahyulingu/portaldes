<?php

namespace App\Actions\Sid\Pamong;

use App\Abstractions\Action\Action;
use App\Actions\Sid\Pamong\Profile\ProfileStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Pamong\SidPamong;
use App\Models\Sid\Pamong\SidPamongProfile;
use App\Models\Sid\SidPenduduk;
use App\Repositories\Sid\Pamong\SidPamongRepository;
use App\Repositories\Sid\SidPendudukRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @extends Action<SidPamong>
 */
class PamongStoreAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected ProfileStoreAction $profileStoreAction,
        readonly protected SidPamongRepository $sidPamongRepository,
        readonly protected SidPendudukRepository $sidPendudukRepository
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'nik' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'nipd' => ['required', 'numeric'],
            'jabatan' => 'required|string',
            'golongan' => 'required|string',
            'tupoksi' => 'required|string',
            'tgl_pengangkatan' => 'required|date',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return DB::transaction(function () use ($validatedPayload, $payload) {
            if (!$this->sidPendudukRepository->findByNik($validatedPayload->get('nik'))) {
                $this->profileStoreAction->execute($payload);

                return $this->sidPamongRepository->store([
                    'profile_type' => SidPamongProfile::class,
                    ...$validatedPayload,
                ]);
            }

            return $this->sidPamongRepository->store([
                'profile_type' => SidPenduduk::class,
                ...$validatedPayload,
            ]);
        });
    }
}
