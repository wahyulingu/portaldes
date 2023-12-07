<?php

namespace App\Models\Content;

use App\Abstractions\Model\ContentModel;
use App\Contracts\Model\HasThumbnailContract;
use App\Traits\Model\HasRepository;
use App\Traits\Model\Relations\BelongsToUser;
use App\Traits\Model\Relations\Content\MorphOneThumbnail;
use App\Traits\Model\Relations\Content\MorphToManyCategories;
use App\Traits\Model\Slug\SluggableByTitle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentArticle extends ContentModel implements HasThumbnailContract
{
    use HasFactory;
    use SluggableByTitle;
    use MorphOneThumbnail;
    use MorphToManyCategories;
    use BelongsToUser;
    use HasRepository;
    use MorphToManyCategories;

    protected $guarded = ['id'];
}
