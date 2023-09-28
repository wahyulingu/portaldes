<?php

namespace App\Traits\Model\Relations\Sid;

use App\Models\Sid\Pamong\SidPamong;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSidPamong
{
    /**
     * A model may have multiple files.
     */
    public function pamong(): BelongsTo
    {
        return $this->belongsTo(SidPamong::class);
    }
}
