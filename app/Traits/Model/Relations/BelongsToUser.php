<?php

namespace App\Traits\Model\Relations;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToUser
{
    /**
     * A model may have multiple files.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
