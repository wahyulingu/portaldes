<?php

namespace App\Actions\Sid\Identitas;

use App\Abstractions\Action\Action;
use App\Repositories\MetaRepository;

class IdentitasFetchAction extends Action
{
    public function __construct(readonly protected MetaRepository $metaRepository)
    {
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $identitas = [
            'nama_desa' => '',
            'alamat' => '',
            'telepon' => '',
            'email' => '',
            'website' => '',
            'kode_desa' => '',
            'nama_kepala_desa' => '',
            'kodepos' => '',
            'nama_kecamatan' => '',
            'kode_kecamatan' => '',
            'nama_kepala_camat' => '',
            'nama_kabupaten' => '',
            'kode_kabupaten' => '',
            'provinsi' => '',
        ];

        if ($meta = $this->metaRepository->findBySlug('sid-identitas')) {
            $identitas = [...$identitas, ...$meta->value];
        }

        return $identitas;
    }
}
