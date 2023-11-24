<?php

namespace App\Models\Content;

use App\Abstractions\Model\ContentModel;
use App\Contracts\Model\HasPictureContract;
use App\Traits\Model\Relations\Media\BelongsToPicture;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentThumbnail extends ContentModel implements HasPictureContract
{
    use BelongsToPicture;
    use HasFactory;

    protected $fillable = ['picture_id', 'content_id', 'content_type'];
}
