<?php

namespace App\Traits\Model\Relations\Content;

use App\Models\Content\ContentCategory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait MorphToManyCategories
{
    /**
     * A model may have multiple categories.
     */
    public function categories(): MorphToMany
    {
        return $this->morphToMany(ContentCategory::class, 'content_model_has_categories', 'content_model_has_categories');
    }
}
