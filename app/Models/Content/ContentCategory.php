<?php

namespace App\Models\Content;

use App\Abstractions\Model\ContentModel;
use App\Traits\Model\HasRepository;
use App\Traits\Model\Relations\BelongsToParent;
use App\Traits\Model\Relations\HasManyChilds;
use App\Traits\Model\Slug\SluggableByName;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentCategory extends ContentModel
{
    use HasFactory;
    use SluggableByName;
    use HasRepository;
    use BelongsToParent;
    use HasManyChilds;

    protected $fillable = ['name', 'description', 'parent_id', 'status'];
}
