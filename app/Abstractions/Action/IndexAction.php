<?php

namespace App\Abstractions\Action;

use App\Abstractions\Repository\Repository;
use App\Contracts\Action\PaginatedIndexContract;
use App\Contracts\Action\RuledActionContract;
use Illuminate\Support\Collection;

abstract class IndexAction extends Action implements RuledActionContract
{
    public function __construct(readonly protected Repository $repository)
    {
    }

    public function rules(Collection $payload): array
    {
        $rules = [
            'keyword' => 'nullable|string',
            'columns' => 'nullable|array',
            'limit' => 'nullable|numeric|min:1',
            'relations' => 'nullable|array',
            'relationsCount' => 'nullable|array',
        ];

        if ($this instanceof PaginatedIndexContract) {
            return [...$rules, 'pageName' => 'nullable|string'];
        }

        return [...$rules, 'offset' => 'nullable|numeric'];
    }

    protected function filters(Collection $payload): array
    {
        return [];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        $this

            ->repository
            ->filter($this->filters($validatedPayload))
            ->latest();

        if (!empty($validatedPayload['relations'])) {
            $this->repository->with($validatedPayload['relations']);
        }

        if (!empty($validatedPayload['relationsCount'])) {
            $this->repository->withCount($validatedPayload['relationsCount']);
        }

        if ($this instanceof PaginatedIndexContract) {
            return $this

                ->repository
                ->paginate(
                    limit: @$validatedPayload['limit'] ?: 1,
                    columns: @$validatedPayload['columns'] ?: ['*'],
                    pageName: @$validatedPayload['pageName'] ?: 'page'
                );
        }

        if (!empty($validatedPayload['offset'])) {
            $this->repository->offset($validatedPayload['offset']);
        }

        if (!empty($validatedPayload['limit'])) {
            $this->repository->limit($validatedPayload['limit']);
        }

        return $this

            ->repository
            ->get(@$validatedPayload['columns'] ?: ['*']);
    }
}
