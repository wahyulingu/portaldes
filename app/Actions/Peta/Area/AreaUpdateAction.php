<?php

namespace App\Actions\Peta\Area;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Peta\PetaArea;
use App\Models\Peta\PetaCategory;
use App\Repositories\Peta\PetaAreaRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class AreaUpdateAction extends Action implements RuledActionContract
{
    protected PetaArea $area;

    public function __construct(
        protected readonly PetaAreaRepository $petaAreaRepository,
        protected readonly GambarStoreAction $gambarStoreAction,
        protected readonly GambarUpdateAction $gambarUpdateAction
    ) {
    }

    public function prepare(PetaArea $area)
    {
        return tap($this, fn (self $action) => $action->area = $area);
    }

    public function rules(Collection $payload): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'body' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string', 'max:255'],
            'category_id' => ['sometimes', Rule::exists(PetaCategory::class, 'id')],
            'area' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'gambar' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if (isset($validatedPayload['gambar'])) {
            $this->updateGambar($validatedPayload['gambar']);

            unset($validatedPayload['gambar']);
        }

        if (empty($validatedPayload)) {
            return true;
        }

        return $this->petaAreaRepository->update($this->area->getKey(), $validatedPayload);
    }

    protected function updateGambar(UploadedFile $image)
    {
        if ($this->area->gambar()->exists()) {
            return $this

                ->gambarUpdateAction
                ->prepare($this->area->gambar)
                ->execute(compact('image'));
        }

        return $this

            ->gambarStoreAction
            ->execute(compact('image'));
    }
}
