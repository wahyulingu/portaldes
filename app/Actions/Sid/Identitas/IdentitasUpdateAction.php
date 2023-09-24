<?php

namespace App\Actions\Sid\Identitas;

use App\Abstractions\Action\Action;
use App\Actions\Meta\MetaStoreAction;
use App\Actions\Meta\MetaUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\SidIdentitas;
use App\Repositories\MetaRepository;

/**
 * @extends Action<SidIdentitas>
 */
class IdentitasUpdateAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected MetaRepository $metaRepository,
        readonly protected MetaStoreAction $metaStoreAction,
        readonly protected MetaUpdateAction $metaUpdateAction
    ) {
    }

    public function rules(array $payload): array
    {
        return [
            'nama_desa' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'email' => 'required|string',
            'website' => 'required|string',
            'kode_desa' => 'required|numeric',
            'nama_kepala_desa' => 'required|string',
            'kodepos' => 'required|numeric',
            'nama_kecamatan' => 'required|string',
            'kode_kecamatan' => 'required|numeric',
            'nama_kepala_camat' => 'required|string',
            'nama_kabupaten' => 'required|string',
            'kode_kabupaten' => 'required|numeric',
            'provinsi' => 'required|integer',
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        if ($meta = $this->metaRepository->findBySlug('sid-identitas')) {
            return (bool) $this

                ->metaUpdateAction
                ->prepare($meta)
                ->execute(['value' => $validatedPayload]);
        }

        return (bool) $this

            ->metaStoreAction
            ->execute([
                'name' => 'Sid Identitas',
                'value' => $validatedPayload,
            ]);
    }
}
