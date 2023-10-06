<?php

namespace App\Repositories\Content;

use App\Abstractions\Repository\ContentRepository;
use App\Models\Content\ContentArticle;

/**
 * @extends ContentRepository<ContentArticle>
 */
class ContentCategoryRepository extends ContentRepository
{
    public function indexNoparentOnly()
    {
    }
}
