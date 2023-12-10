<?php

namespace App\Actions\Sid\Bantuan;

use App\Abstractions\Action\Action;
use App\Actions\Sid\Penduduk\PendudukStoreAction;
use App\Actions\Sid\Penduduk\PendudukUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Penduduk\HubunganBantuan;
use App\Enumerations\Penduduk\Status\Sosial;
use App\Models\Sid\SidBantuan;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Repositories\Sid\SidBantuanRepository;
use App\Repositories\Sid\SidPendudukRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidBantuan>
 */
class BantuanStoreAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected SidBantuanRepository $sidBantuanRepository,
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
            'nomor_kartu_bantuan' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'alamat' => 'required|string',
            'sosial' => ['required', Rule::enum(Sosial::class)],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return DB::transaction(function () use ($validatedPayload, $payload) {
            if ($kepalaBantuan = $this->sidPendudukRepository->findByNik($validatedPayload['nik'])) {
                $this->pendudukUpdateAction->prepare($kepalaBantuan)->execute([
                    'nomor_kartu_bantuan' => $validatedPayload['nomor_kartu_bantuan'],
                    'hubungan_bantuan' => HubunganBantuan::kepala->value,
                ]);
            } else {
                $this->pendudukStoreAction->execute([
                    ...$payload, 'hubungan_bantuan' => HubunganBantuan::kepala->value,
                ]);
            }

            unset($validatedPayload['nik']);

            return $this->sidBantuanRepository->store($validatedPayload);
        });
    }
}
