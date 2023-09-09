<?php

namespace App\Models\Content;

use App\Abstractions\Model\ContentModel;
use App\Contracts\Model\HasPicture;
use App\Traits\Model\Relations\Media\MorphOnePicture;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentThumbnail extends ContentModel implements HasPicture
{
    use MorphOnePicture;
    use HasFactory;
}
