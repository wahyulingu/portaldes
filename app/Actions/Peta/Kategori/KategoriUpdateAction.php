<?php

namespace App\Actions\Peta\Kategori;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Peta\PetaCategory;
use App\Models\Peta\PetaKategori;
use App\Repositories\Peta\PetaKategoriRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class KategoriUpdateAction extends Action implements RuledActionContract
{
    protected PetaKategori $kategori;

    public function __construct(
        protected readonly PetaKategoriRepository $petaKategoriRepository,
        protected readonly GambarStoreAction $gambarStoreAction,
        protected readonly GambarUpdateAction $gambarUpdateAction
    ) {
    }

    public function prepare(PetaKategori $kategori)
    {
        return tap($this, fn (self $action) => $action->kategori = $kategori);
    }

    public function rules(array $payload): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'body' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string', 'max:255'],
            'category_id' => ['sometimes', Rule::exists(PetaCategory::class, 'id')],
            'kategori' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'gambar' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        if (isset($validatedPayload['gambar'])) {
            $this->updateGambar($validatedPayload['gambar']);

            unset($validatedPayload['gambar']);
        }

        if (empty($validatedPayload)) {
            return true;
        }

        return $this->petaKategoriRepository->update($this->kategori->getKey(), $validatedPayload);
    }

    protected function updateGambar(UploadedFile $image)
    {
        if ($this->kategori->gambar()->exists()) {
            return $this

                ->gambarUpdateAction
                ->prepare($this->kategori->gambar)
                ->execute(compact('image'));
        }

        return $this

            ->gambarStoreAction
            ->prepare($this->kategori)
            ->execute(compact('image'));
    }
}
