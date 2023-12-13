<?php

namespace App\Actions\Sid\Wilayah\Lingkungan;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Wilayah\SidWilayahLingkungan;
use App\Models\Sid\WilayahLingkungan;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<WilayahLingkungan>
 */
class LingkunganUpdateAction extends Action implements RuledActionContract
{
    protected SidWilayahLingkungan $lingkungan;

    public function prepare(SidWilayahLingkungan $lingkungan)
    {
        return tap($this, fn (self $action) => $action->lingkungan = $lingkungan);
    }

    public function rules(Collection $payload): array
    {
        return [
            'ketua_id' => ['sometimes', 'integer', Rule::exists(SidPenduduk::class, 'id')],
            'nama' => 'sometimes|string|min:4|max:32',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->lingkungan->update($validatedPayload->toArray());
    }
}
