<?php

namespace App\Actions\Peta\Area;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Peta\PetaArea;
use App\Models\Peta\PetaCategory;
use App\Models\User;
use App\Repositories\Peta\PetaAreaRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<PetaArea>
 */
class AreaStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        protected PetaAreaRepository $petaAreaRepository,
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],

            'user_id' => [
                'required',
                Rule::exists(User::class, 'id'),
            ],

            'category_id' => [
                'sometimes',
                Rule::exists(PetaCategory::class, 'id'),
            ],

            'status' => [
                'sometimes',
                Rule::in(Moderation::names()),
            ],

            'gambar' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return tap(
            $this->petaAreaRepository->store($validatedPayload),
            function (PetaArea $peta) {
                // if (isset($validatedPayload['gambar'])) {
                //     $this

                //         ->gambarStoreAction
                //         ->prepare($peta)
                //         ->skipAllRules()
                //         ->execute($validatedPayload);
                // }
            }
        );
    }
}
