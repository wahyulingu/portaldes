<?php

namespace App\Traits\Model\Slug;

use Cviebrock\EloquentSluggable\Sluggable;

trait SluggableByName
{
    use Sluggable;

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'name']];
    }
}
