<?php

namespace App\Actions\Sid\Wilayah\RukunWarga;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Wilayah\SidWilayahRukunWarga;
use App\Models\Sid\WilayahRukunWarga;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<WilayahRukunWarga>
 */
class RukunWargaUpdateAction extends Action implements RuledActionContract
{
    protected SidWilayahRukunWarga $rukunWarga;

    public function prepare(SidWilayahRukunWarga $rukunWarga)
    {
        return tap($this, fn (self $action) => $action->rukunWarga = $rukunWarga);
    }

    public function rules(Collection $payload): array
    {
        return [
            'lingkungan_id' => ['sometimes', 'integer', Rule::exists(SidWilayahLingkungan::class, 'id')],
            'ketua_id' => ['sometimes', 'integer', Rule::exists(SidPenduduk::class, 'id')],
            'nama' => 'sometimes|string|min:4|max:32',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->rukunWarga->update($validatedPayload->toArray());
    }
}
