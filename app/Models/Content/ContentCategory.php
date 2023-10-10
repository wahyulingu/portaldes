<?php

namespace App\Models\Content;

use App\Abstractions\Model\ContentModel;
use App\Traits\Model\HasRepository;
use App\Traits\Model\Relations\BelongsToParent;
use App\Traits\Model\Relations\HasManyChilds;
use App\Traits\Model\Slug\SluggableByName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ContentCategory extends ContentModel
{
    use HasFactory;
    use SluggableByName;
    use HasRepository;
    use BelongsToParent;
    use HasManyChilds;

    protected $fillable = ['name', 'description', 'parent_id', 'status'];

    public function articles(): MorphToMany
    {
        return $this->morphedByMany(ContentArticle::class, 'content_model_has_categories');
    }

    public function pages(): MorphToMany
    {
        return $this->morphedByMany(ContentPage::class, 'content_model_has_categories');
    }
}
