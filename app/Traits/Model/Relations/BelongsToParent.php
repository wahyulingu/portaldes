<?php

namespace App\Traits\Model\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToParent
{
    /**
     * A model may have multiple files.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo($this::class);
    }
}
