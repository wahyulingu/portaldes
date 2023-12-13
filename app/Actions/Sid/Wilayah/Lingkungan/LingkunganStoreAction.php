<?php

namespace App\Actions\Sid\Wilayah\Lingkungan;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\SidPenduduk;
use App\Models\Sid\WilayahLingkungan;
use App\Repositories\Sid\Wilayah\SidWilayahLingkunganRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<WilayahLingkungan>
 */
class LingkunganStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected SidWilayahLingkunganRepository $sidWilayahLingkunganRepository)
    {
    }

    public function rules(Collection $payload): array
    {
        return [
            'ketua_id' => ['required', 'integer', Rule::exists(SidPenduduk::class, 'id')],
            'nama' => 'required|string|min:4|max:32',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->sidWilayahLingkunganRepository->store($validatedPayload);
    }
}
