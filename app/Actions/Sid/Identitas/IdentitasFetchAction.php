<?php

namespace App\Actions\Sid\Identitas;

use App\Abstractions\Action\Action;
use App\Repositories\Media\MediaPictureRepository;
use App\Repositories\MetaRepository;

class IdentitasFetchAction extends Action
{
    public function __construct(
        readonly protected MediaPictureRepository $mediaPictureRepository,
        readonly protected MetaRepository $metaRepository
    ) {
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
            'nama_kades' => '',
            'kodepos' => '',
            'nama_kecamatan' => '',
            'kode_kecamatan' => '',
            'nama_camat' => '',
            'nama_kabupaten' => '',
            'nama_bupati' => '',
            'kode_kabupaten' => '',
            'lat' => '',
            'long' => '',
            'logo' => '',
            'stamp' => '',
            'nama_provinsi' => '',
            'nama_gubernur' => '',
            'kode_provinsi' => '',
        ];

        if ($meta = $this->metaRepository->findBySlug('sid-identitas')) {
            $identitas = [...$identitas, ...$meta->value];

            $logoModel = $this->mediaPictureRepository->find($identitas['logo']);
            $stampModel = $this->mediaPictureRepository->find($identitas['stamp']);

            $identitas['logo'] = [
                    'path' => @$logoModel->file->path,
                    'url' => @$logoModel->file->url,
                ];

            $identitas['stamp'] = [
                'path' => @$stampModel->file->path,
                'url' => @$stampModel->file->url,
            ];
        }

        return $identitas;
    }
}
