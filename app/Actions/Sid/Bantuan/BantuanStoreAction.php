<?php

namespace App\Actions\Sid\Bantuan;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\SasaranBantuan;
use App\Models\Sid\SidBantuan;
use App\Repositories\Sid\SidBantuanRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidBantuan>
 */
class BantuanStoreAction extends Action implements RuledActionContract
{
    public function __construct(readonly protected SidBantuanRepository $sidBantuanRepository)
    {
    }

    public function rules(array $payload): array
    {
        return [
            'awal' => 'required|date',
            'akhir' => 'nullable|date',
            'nama' => 'required|string',
            'keterangan' => 'required|string',
            'sasaran' => ['required', Rule::enum(SasaranBantuan::class)],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->sidBantuanRepository->store($validatedPayload);
    }
}
