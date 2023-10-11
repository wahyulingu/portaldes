<?php

namespace App\Abstractions\Action;

use App\Abstractions\Repository\Repository;
use App\Contracts\Action\RuledActionContract;

abstract class IndexAction extends Action implements RuledActionContract
{
    protected Repository $repository;

    public function rules(array $payload): array
    {
        return [
            'keyword' => ['nullable', 'string'],
            'columns' => ['nullable', 'array'],
            'limit' => ['nullable', 'numeric'],
        ];
    }
}
