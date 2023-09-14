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
            'nik' => ['sometimes', 'string', 'regex:/^[0-9]{16}$/'],
            'nipd' => ['sometimes', 'numeric'],
            'foto' => 'sometimes|image',
            'telepon' => 'sometimes|string',
            'alamat_sekarang' => 'sometimes|string',
            'nama' => 'sometimes|string',
            'tempat_lahir' => 'sometimes|string',
            'email' => 'sometimes|string|email',
            'kelamin' => ['sometimes', Rule::enum(JenisKelamin::class)],
            'agama' => ['sometimes', Rule::enum(Agama::class)],
            'pendidikan_kk' => ['sometimes', Rule::enum(Pendidikan::class)],
            'tgl_lahir' => 'sometimes|date',
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->sidPamongRepository->update($this->pamong->getKey(), $validatedPayload);
    }
}
