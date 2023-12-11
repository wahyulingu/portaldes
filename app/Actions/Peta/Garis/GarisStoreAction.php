<?php

namespace App\Actions\Peta\Garis;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Peta\PetaCategory;
use App\Models\Peta\PetaGaris;
use App\Models\User;
use App\Repositories\Peta\PetaGarisRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<PetaGaris>
 */
class GarisStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        protected PetaGarisRepository $petaGarisRepository,
    ) {
    }

    public function rules(array $payload): array
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
            $this->petaGarisRepository->store($validatedPayload),
            function (PetaGaris $peta) {
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
