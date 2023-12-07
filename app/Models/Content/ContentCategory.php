<?php

namespace App\Models\Content;

use App\Abstractions\Model\ContentModel;
use App\Enumerations\Content\CategoryStatus;
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

    protected $csats = ['status' => CategoryStatus::class];

    protected $guarded = ['id'];

    public function articles(): MorphToMany
    {
        return $this->modelHasCategories(ContentArticle::class);
    }

    public function pages(): MorphToMany
    {
        return $this->modelHasCategories(ContentPage::class);
    }

    protected function modelHasCategories($model): MorphToMany
    {
        return $this->morphedByMany($model, 'content_model_has_categories');
    }
}
