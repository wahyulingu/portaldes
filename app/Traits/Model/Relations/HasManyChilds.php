<?php

namespace App\Traits\Model\Relations;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyChilds
{
    /**
     * A model may have multiple files.
     */
    public function childs(): HasMany
    {
        return $this->hasMany($this::class, 'parent_id');
    }
}
