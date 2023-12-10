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
            'awal' => 'sometimes|date',
            'akhir' => 'sometimes|date',
            'nama' => 'sometimes|string',
            'keterangan' => 'sometimes|string',
            'sasaran' => ['sometimes', Rule::enum(SasaranBantuan::class)],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->sidBantuanRepository->update($this->bantuan->getKey(), $validatedPayload);
    }
}
