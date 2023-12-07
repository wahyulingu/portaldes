<?php

namespace App\Repositories\Content;

use App\Abstractions\Repository\ContentRepository;
use App\Contracts\Model\HasThumbnailContract;
use App\Models\Content\ContentThumbnail;
use Illuminate\Database\Eloquent\Model;

class ContentThumbnailRepository extends ContentRepository
{
    public function create(Model&HasThumbnailContract $content): ContentThumbnail
    {
        return $content->thumbnail()->create();
    }
}
