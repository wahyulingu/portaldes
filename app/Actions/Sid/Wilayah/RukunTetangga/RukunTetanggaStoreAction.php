<?php

namespace App\Actions\Sid\Wilayah\RukunTetangga;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\SidPenduduk;
use App\Models\Sid\Wilayah\SidWilayahRukunWarga;
use App\Models\Sid\WilayahRukunTetangga;
use App\Repositories\Sid\Wilayah\SidWilayahRukunTetanggaRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<WilayahRukunTetangga>
 */
class RukunTetanggaStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected SidWilayahRukunTetanggaRepository $sidWilayahRukunTetanggaRepository)
    {
    }

    public function rules(Collection $payload): array
    {
        return [
            'rukun_warga_id' => ['required', 'integer', Rule::exists(SidWilayahRukunWarga::class, 'id')],
            'ketua_id' => ['required', 'integer', Rule::exists(SidPenduduk::class, 'id')],
            'nama' => 'required|string|min:4|max:32',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->sidWilayahRukunTetanggaRepository->store($validatedPayload);
    }
}
