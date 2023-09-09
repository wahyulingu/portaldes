<?php

namespace App\Traits\Model\Slug;

use Cviebrock\EloquentSluggable\Sluggable;

trait SluggableByTitle
{
    use Sluggable;

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'title']];
    }
}
