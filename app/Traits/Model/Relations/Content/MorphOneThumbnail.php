<?php

namespace App\Traits\Model\Relations\Content;

use App\Models\Content\ContentThumbnail;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphOneThumbnail
{
    /**
     * A model may have multiple files.
     */
    public function thumbnail(): MorphOne
    {
        return $this->morphOne(ContentThumbnail::class, 'content');
    }
}
