<?php

namespace App\Actions\Sid\Pamong;

use App\Abstractions\Action\Action;
use App\Actions\Sid\Pamong\Profile\ProfileUpdateAction;
use App\Actions\Sid\Penduduk\PendudukUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Pamong\SidPamong;
use App\Models\Sid\SidPenduduk;
use App\Repositories\Sid\Pamong\SidPamongRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @extends Action<SidPamong>
 */
class PamongUpdateAction extends Action implements RuledActionContract
{
    protected SidPamong $pamong;

    public function __construct(
        readonly protected SidPamongRepository $sidPamongRepository,
        readonly protected ProfileUpdateAction $profileUpdateAction,
        readonly protected PendudukUpdateAction $pendudukUpdateAction
    ) {
    }

    public function prepare(SidPamong $pamong)
    {
        return tap($this, fn (self $action) => $action->pamong = $pamong);
    }

    public function rules(Collection $payload): array
    {
        return [
            'nik' => ['sometimes', 'string', 'regex:/^[0-9]{16}$/'],
            'nipd' => ['sometimes', 'numeric'],
            'jabatan' => 'sometimes|string',
            'golongan' => 'sometimes|string',
            'tupoksi' => 'sometimes|string',
            'tgl_pengangkatan' => 'sometimes|date',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return DB::transaction(function () use ($validatedPayload, $payload) {
            if ($this->pamong->profile instanceof SidPenduduk) {
                $this

                    ->pendudukUpdateAction
                    ->prepare($this->pamong->profile)
                    ->execute($payload);
            } else {
                $this

                ->profileUpdateAction
                ->prepare($this->pamong->profile)
                ->execute($payload);
            }

            return $this

                ->sidPamongRepository
                ->update($this->pamong->getKey(), $validatedPayload);
        });
    }
}
