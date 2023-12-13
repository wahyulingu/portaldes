<?php

namespace App\Actions\Sid\Keluarga;

use App\Abstractions\Action\Action;
use App\Actions\Sid\Penduduk\PendudukStoreAction;
use App\Actions\Sid\Penduduk\PendudukUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Penduduk\HubunganKeluarga;
use App\Enumerations\Penduduk\Status\Sosial;
use App\Models\Sid\SidKeluarga;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Repositories\Sid\SidKeluargaRepository;
use App\Repositories\Sid\SidPendudukRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidKeluarga>
 */
class KeluargaStoreAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected SidKeluargaRepository $sidKeluargaRepository,
        readonly protected SidPendudukRepository $sidPendudukRepository,
        readonly protected PendudukStoreAction $pendudukStoreAction,
        readonly protected PendudukUpdateAction $pendudukUpdateAction
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'rukun_tetangga_id' => ['required', 'integer', Rule::exists(SidWilayahRukunTetangga::class, 'id')],
            'nik' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'nomor_kartu_keluarga' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'alamat' => 'required|string',
            'sosial' => ['required', Rule::enum(Sosial::class)],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return DB::transaction(function () use ($validatedPayload, $payload) {
            if ($kepalaKeluarga = $this->sidPendudukRepository->findByNik($validatedPayload->get('nik'))) {
                $this->pendudukUpdateAction->prepare($kepalaKeluarga)->execute([
                    'nomor_kartu_keluarga' => $validatedPayload->get('nomor_kartu_keluarga'),
                    'hubungan_keluarga' => HubunganKeluarga::kepala->value,
                ]);
            } else {
                $this->pendudukStoreAction->execute([
                    ...$payload, 'hubungan_keluarga' => HubunganKeluarga::kepala->value,
                ]);
            }

            $validatedPayload->forget('nik');

            return $this->sidKeluargaRepository->store($validatedPayload);
        });
    }
}
