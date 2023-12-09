<?php

namespace App\Repositories\Sid;

use App\Abstractions\Repository\SidRepository;
use App\Models\Sid\SidPenduduk;

class SidPendudukRepository extends SidRepository
{
    public function findByNik(string $nik, $columns = ['*'], array $realations = []): ?SidPenduduk
    {
        if (!empty($realations)) {
            return $this->model(fn (string $model) => $model::with($realations)->whereNik($nik)->first($columns));
        }

        return $this->model(fn (string $model) => $model::whereNik($nik)->first($columns));
    }

    public function nikExists(string $nik): bool
    {
        return $this->model(fn (string $model) => $model::whereNik($nik)->exists());
    }
}
