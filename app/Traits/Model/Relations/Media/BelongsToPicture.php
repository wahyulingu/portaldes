<?php

namespace App\Traits\Model\Relations\Media;

use App\Models\Media\MediaPicture;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToPicture
{
    /**
     * A model may have multiple files.
     */
    public function picture(): BelongsTo
    {
        return $this->belongsTo(MediaPicture::class);
    }
}
