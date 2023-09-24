<?php

namespace App\Repositories;

use App\Abstractions\Repository\Repository;
use App\Models\Meta;

class MetaRepository extends Repository
{
    public function findBySlug(string $slug): ?Meta
    {
        return $this->model(fn (string $model) => $model::whereSlug($slug)->first());
    }
}
