<?php

namespace App\Actions\Sid\Wilayah\RukunTetangga;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Models\Sid\WilayahRukunTetangga;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<WilayahRukunTetangga>
 */
class RukunTetanggaUpdateAction extends Action implements RuledActionContract
{
    protected SidWilayahRukunTetangga $rukunTetangga;

    public function prepare(SidWilayahRukunTetangga $rukunTetangga)
    {
        return tap($this, fn (self $action) => $action->rukunTetangga = $rukunTetangga);
    }

    public function rules(Collection $payload): array
    {
        return [
            'rukun_warga_id' => ['sometimes', 'integer', Rule::exists(SidWilayahRukunWarga::class, 'id')],
            'ketua_id' => ['sometimes', 'integer', Rule::exists(SidPenduduk::class, 'id')],
            'nama' => 'sometimes|string|min:4|max:32',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->rukunTetangga->update($validatedPayload->toArray());
    }
}
