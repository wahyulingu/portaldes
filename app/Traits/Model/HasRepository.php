<?php

namespace App\Traits\Model;

use App\Abstractions\Repository\Repository;

trait HasRepository
{
    /**
     * Get a new repository instance for the model.
     *
     * @return \App\Abstractions\Repository<static>
     */
    public static function repository()
    {
        return Repository::repositoryForModel(get_called_class());
    }
}
