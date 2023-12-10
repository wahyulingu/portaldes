<?php

namespace App\Actions\Sid\Bantuan;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\SidBantuan;
use App\Repositories\Sid\SidBantuanRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidBantuan>
 */
class BantuanUpdateAction extends Action implements RuledActionContract
{
    protected SidBantuan $bantuan;

    public function __construct(protected SidBantuanRepository $sidBantuanRepository)
    {
    }

    public function prepare(SidBantuan $bantuan)
    {
        return tap($this, fn (self $action) => $action->bantuan = $bantuan);
    }

    public function rules(array $payload): array
    {
        return [
            'rukun_tetangga_id' => ['sometimes', 'integer', Rule::exists(SidWilayahRukunTetangga::class, 'id')],
            'nik' => ['sometimes', 'string', 'regex:/^[0-9]{16}$/'],
            'nomor_kartu_bantuan' => ['sometimes', 'string', 'regex:/^[0-9]{16}$/'],
            'alamat' => 'sometimes|string',
            'sosial' => ['sometimes', Rule::enum(Sosial::class)],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->sidBantuanRepository->update($this->bantuan->getKey(), $validatedPayload);
    }
}
