<?php

namespace App\Traits\Model\Relations\Content;

use App\Models\Content\ContentCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCategory
{
    /**
     * A model may have multiple files.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ContentCategory::class);
    }
}
