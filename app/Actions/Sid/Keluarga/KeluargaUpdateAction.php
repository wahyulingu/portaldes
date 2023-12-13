<?php

namespace App\Actions\Sid\Keluarga;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\SidKeluarga;
use App\Repositories\Sid\SidKeluargaRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidKeluarga>
 */
class KeluargaUpdateAction extends Action implements RuledActionContract
{
    protected SidKeluarga $keluarga;

    public function __construct(protected SidKeluargaRepository $sidKeluargaRepository)
    {
    }

    public function prepare(SidKeluarga $keluarga)
    {
        return tap($this, fn (self $action) => $action->keluarga = $keluarga);
    }

    public function rules(Collection $payload): array
    {
        return [
            'rukun_tetangga_id' => ['sometimes', 'integer', Rule::exists(SidWilayahRukunTetangga::class, 'id')],
            'nik' => ['sometimes', 'string', 'regex:/^[0-9]{16}$/'],
            'nomor_kartu_keluarga' => ['sometimes', 'string', 'regex:/^[0-9]{16}$/'],
            'alamat' => 'sometimes|string',
            'sosial' => ['sometimes', Rule::enum(Sosial::class)],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->sidKeluargaRepository->update($this->keluarga->getKey(), $validatedPayload);
    }
}
