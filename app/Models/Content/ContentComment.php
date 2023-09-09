<?php

namespace App\Models\Content;

use App\Abstractions\Model\ContentModel;
use App\Traits\Model\Relations\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentComment extends ContentModel
{
    use HasFactory;
    use BelongsToUser;

    protected $fillable = ['body', 'parent_id', 'user_id', 'content_id', 'content_type'];
}
