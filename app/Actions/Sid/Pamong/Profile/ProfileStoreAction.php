<?php

namespace App\Actions\Sid\Pamong\Profile;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Medis\JenisKelamin;
use App\Enumerations\Pendidikan\Pendidikan;
use App\Enumerations\Penduduk\Agama;
use App\Models\Sid\Pamong\SidPamongProfile;
use App\Repositories\Sid\Pamong\SidPamongProfileRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidPamongProfile>
 */
class ProfileStoreAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected SidPamongProfileRepository $sidPamongProfileRepository
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'nik' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'nipd' => ['required', 'numeric'],
            'foto' => 'sometimes|image',
            'telepon' => 'required|string',
            'alamat_sekarang' => 'required|string',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'email' => 'required|string|email',
            'kelamin' => ['required', Rule::enum(JenisKelamin::class)],
            'agama' => ['required', Rule::enum(Agama::class)],
            'pendidikan_kk' => ['required', Rule::enum(Pendidikan::class)],
            'tgl_lahir' => 'required|date',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->sidPamongProfileRepository->store($validatedPayload);
    }
}
