<?php

namespace App\Actions\Sid\Pamong;

use App\Abstractions\Action\Action;
use App\Actions\Sid\Penduduk\PendudukStoreAction;
use App\Actions\Sid\Penduduk\PendudukUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Penduduk\HubunganPamong;
use App\Enumerations\Penduduk\Status\Sosial;
use App\Models\Sid\Pamong\SidPamong;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Repositories\Sid\Pamong\SidPamongRepository;
use App\Repositories\Sid\SidPendudukRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidPamong>
 */
class PamongStoreAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected SidPamongRepository $sidPamongRepository,
        readonly protected SidPendudukRepository $sidPendudukRepository,
        readonly protected PendudukStoreAction $pendudukStoreAction,
        readonly protected PendudukUpdateAction $pendudukUpdateAction
    ) {
    }

    public function rules(array $payload): array
    {
        return [
            'rukun_tetangga_id' => ['required', 'integer', Rule::exists(SidWilayahRukunTetangga::class, 'id')],
            'nik' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'no_kk' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'alamat' => 'required|string',
            'sosial' => ['required', Rule::enum(Sosial::class)],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return DB::transaction(function () use ($validatedPayload, $payload) {
            if ($kepalaPamong = $this->sidPendudukRepository->findByNik($validatedPayload['nik'])) {
                $this->pendudukUpdateAction->prepare($kepalaPamong)->execute([
                    'no_kk' => $validatedPayload['no_kk'],
                    'hubungan_pamong' => HubunganPamong::kepala->value,
                ]);
            } else {
                $this->pendudukStoreAction->execute([
                    ...$payload, 'hubungan_pamong' => HubunganPamong::kepala->value,
                ]);
            }

            unset($validatedPayload['nik']);

            return $this->sidPamongRepository->store($validatedPayload);
        });
    }
}
