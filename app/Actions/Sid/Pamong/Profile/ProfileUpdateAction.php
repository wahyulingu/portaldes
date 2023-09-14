<?php

namespace App\Actions\Sid\Pamong\Profile;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Pamong\SidPamongProfile;
use App\Repositories\Sid\Pamong\SidPamongProfileRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidPamongProfile>
 */
class ProfileUpdateAction extends Action implements RuledActionContract
{
    protected SidPamongProfile $pamong;

    public function __construct(protected SidPamongProfileRepository $sidPamongRepository)
    {
    }

    public function prepare(SidPamongProfile $pamong)
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
