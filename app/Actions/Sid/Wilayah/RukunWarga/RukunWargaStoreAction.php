<?php

namespace App\Actions\Sid\Wilayah\RukunWarga;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\SidPenduduk;
use App\Models\Sid\Wilayah\SidWilayahLingkungan;
use App\Models\Sid\WilayahRukunWarga;
use App\Repositories\Sid\Wilayah\SidWilayahRukunWargaRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<WilayahRukunWarga>
 */
class RukunWargaStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected SidWilayahRukunWargaRepository $sidWilayahRukunWargaRepository)
    {
    }

    public function rules(Collection $payload): array
    {
        return [
            'lingkungan_id' => ['required', 'integer', Rule::exists(SidWilayahLingkungan::class, 'id')],
            'ketua_id' => ['required', 'integer', Rule::exists(SidPenduduk::class, 'id')],
            'nama' => 'required|string|min:4|max:32',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->sidWilayahRukunWargaRepository->store($validatedPayload);
    }
}
