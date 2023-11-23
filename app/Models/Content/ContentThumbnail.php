<?php

namespace App\Models\Content;

use App\Abstractions\Model\ContentModel;
use App\Contracts\Model\BelongsToPicture;
use App\Traits\Model\Relations\Media\MorphToManyPictures;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentThumbnail extends ContentModel implements BelongsToPicture
{
    use MorphToManyPictures;
    use HasFactory;
}
