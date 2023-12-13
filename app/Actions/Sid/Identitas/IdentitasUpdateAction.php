<?php

namespace App\Actions\Sid\Identitas;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureStoreAction;
use App\Actions\Media\Picture\PictureUpdateAction;
use App\Actions\Meta\MetaStoreAction;
use App\Actions\Meta\MetaUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\SidIdentitas;
use App\Repositories\Media\MediaPictureRepository;
use App\Repositories\MetaRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @extends Action<SidIdentitas>
 */
class IdentitasUpdateAction extends Action implements RuledActionContract
{
    public function __construct(
        readonly protected MediaPictureRepository $mediaPictureRepository,
        readonly protected MetaRepository $metaRepository,
        readonly protected MetaStoreAction $metaStoreAction,
        readonly protected MetaUpdateAction $metaUpdateAction,
        readonly protected PictureStoreAction $pictureStoreAction,
        readonly protected PictureUpdateAction $pictureUpdateAction
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama_desa' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'email' => 'required|string',
            'website' => 'required|string',
            'kode_desa' => 'required|numeric',
            'nama_kades' => 'required|string',
            'kodepos' => 'required|numeric',
            'nama_kecamatan' => 'required|string',
            'kode_kecamatan' => 'required|numeric',
            'nama_camat' => 'required|string',
            'nama_kabupaten' => 'required|string',
            'nama_bupati' => 'required|string',
            'kode_kabupaten' => 'required|numeric',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'logo' => 'nullable|image|max:2048',
            'stamp' => 'nullable|image|max:2048',
            'nama_provinsi' => 'required|string',
            'nama_gubernur' => 'required|string',
            'kode_provinsi' => 'required|numeric',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return DB::transaction(function () use ($validatedPayload) {
            $meta = $this->metaRepository->findBySlug('sid-identitas');

            /*
             * Jika Meta Tersedia Akan Dilakukan Pengecekan Logo dan Stamp
             * jika ditemukan model untuk logo atau stamp model tersebut
             * akan diupdate gambarnya dan kemudian payload akan dihapus
             */
            if (!empty($meta)) {
                if (
                    !empty($meta->value['logo'])
                    && !empty($logoModel = $this->mediaPictureRepository->find($meta->value['logo']))
                    && $validatedPayload->has('logo')
                ) {
                    $this
                        ->pictureUpdateAction
                        ->prepare($logoModel)
                        ->execute([
                            'image' => $validatedPayload->get('logo'),
                            'path' => 'media/picture/sid',
                        ]);

                    $validatedPayload->forget('logo');
                }

                if (
                    !empty($meta->value['stamp'])
                    && !empty($stampModel = $this->mediaPictureRepository->find($meta->value['stamp']))
                    && $validatedPayload->has('stamp')
                ) {
                    $this
                        ->pictureUpdateAction
                        ->prepare($stampModel)
                        ->execute([
                            'image' => $validatedPayload->get('stamp'),
                            'path' => 'media/picture/sid',
                        ]);

                    $validatedPayload->forget('stamp');
                }
            }

            /*
             * jika baris 60 tidak terpenuhi, payload tidak akan terhapus
             * dan akan disimpan ke dalam database dan mengganti payload
             * dengan ID model
             */

            if ($validatedPayload->has('logo')) {
                $validatedPayload->put(
                    'logo',
                    $this

                        ->pictureStoreAction
                        ->execute([
                            'name' => 'Logo Desa',
                            'description' => 'Picture Model untuk Logo Desa',
                            'image' => $validatedPayload['logo'],
                            'path' => 'media/picture/sid',
                        ])
                        ->getKey()
                );
            }

            if ($validatedPayload->has('stamp')) {
                $validatedPayload->put(
                    'stamp',
                    $this

                        ->pictureStoreAction
                        ->execute([
                            'name' => 'Logo Desa',
                            'description' => 'Picture Model untuk Logo Desa',
                            'image' => $validatedPayload['stamp'],
                            'path' => 'media/picture/sid',
                        ])
                        ->getKey()
                );
            }

            if (!empty($meta)) {
                return (bool) $this

                    ->metaUpdateAction
                    ->prepare($meta)

                    ->execute([
                        'value' => [
                            ...$meta->value,
                            ...$validatedPayload->toArray(),
                        ],
                    ]);
            }

            return (bool) $this

                ->metaStoreAction
                ->execute([
                    'name' => 'Sid Identitas',
                    'value' => $validatedPayload,
                ]);
        });
    }
}
