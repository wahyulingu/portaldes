<?php

namespace App\Traits\Model\Relations\Content;

use App\Models\Content\ContentCategory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait MorphToManyCategories
{
    /**
     * A model may have multiple files.
     */
    public function pictures(): MorphToMany
    {
        return $this->morphToMany(ContentCategory::class, 'model_has_media_pictures', 'model_has_media_pictures');
    }
}
