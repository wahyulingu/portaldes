<?php

namespace App\Actions\Meta;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Meta;
use App\Repositories\MetaRepository;

/**
 * @extends Action<Meta>
 */
class MetaUpdateAction extends Action implements RuledActionContract
{
    protected Meta $meta;

    public function __construct(protected MetaRepository $metaRepository)
    {
    }

    public function prepare(Meta $meta)
    {
        return tap($this, fn (self $action) => $action->meta = $meta);
    }

    public function rules(array $payload): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'value' => ['sometimes'],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->metaRepository->update($this->meta->getKey(), $validatedPayload);
    }
}
