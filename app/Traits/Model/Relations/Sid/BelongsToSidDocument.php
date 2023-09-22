<?php

namespace App\Traits\Model\Relations\Sid;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSidDocument
{
    public function document(): BelongsTo
    {
        return $this->belongsTo(SidDocument::class);
    }
}
