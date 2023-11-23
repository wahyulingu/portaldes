<?php

namespace App\Models\Content;

use App\Abstractions\Model\ContentModel;
use App\Contracts\Model\HasThumbnailContract;
use App\Traits\Model\HasRepository;
use App\Traits\Model\Relations\BelongsToUser;
use App\Traits\Model\Relations\Content\BelongsToCategory;
use App\Traits\Model\Relations\Content\MorphOneThumbnail;
use App\Traits\Model\Relations\Content\MorphToManyCategories;
use App\Traits\Model\Slug\SluggableByTitle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentPage extends ContentModel implements HasThumbnailContract
{
    use HasFactory;
    use SluggableByTitle;
    use MorphToManyCategories;
    use MorphOneThumbnail;
    use BelongsToCategory;
    use BelongsToUser;
    use HasRepository;

    protected $fillable = ['title', 'body', 'description', 'user_id', 'category_id'];
}
