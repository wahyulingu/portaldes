<?php

namespace App\Actions\Sid\Pamong;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Pamong\SidPamong;
use App\Repositories\Sid\Pamong\SidPamongRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidPamong>
 */
class PamongUpdateAction extends Action implements RuledActionContract
{
    protected SidPamong $pamong;

    public function __construct(protected SidPamongRepository $sidPamongRepository)
    {
    }

    public function prepare(SidPamong $pamong)
    {
        return tap($this, fn (self $action) => $action->pamong = $pamong);
    }

    public function rules(array $payload): array
    {
        return [
            'rukun_tetangga_id' => ['sometimes', 'integer', Rule::exists(SidWilayahRukunTetangga::class, 'id')],
            'nik' => ['sometimes', 'string', 'regex:/^[0-9]{16}$/'],
            'no_kk' => ['sometimes', 'string', 'regex:/^[0-9]{16}$/'],
            'alamat' => 'sometimes|string',
            'sosial' => ['sometimes', Rule::enum(Sosial::class)],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->sidPamongRepository->update($this->pamong->getKey(), $validatedPayload);
    }
}
