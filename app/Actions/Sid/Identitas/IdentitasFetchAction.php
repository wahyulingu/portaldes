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

            if (!empty($identitas['logo'])) {
                if ($logoModel = $this->mediaPictureRepository->find($identitas['logo'])) {
                    $identitas['logo'] = $logoModel->file->path;
                } else {
                    $identitas['logo'] = '';
                }
            }

            if (!empty($identitas['stamp'])) {
                if ($stampModel = $this->mediaPictureRepository->find($identitas['stamp'])) {
                    $identitas['stamp'] = $stampModel->file->path;
                } else {
                    $identitas['stamp'] = '';
                }
            }
        }

        return $identitas;
    }
}
