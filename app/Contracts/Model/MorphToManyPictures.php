<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface MorphToManyPictures
{
    public function pictures(): MorphMany;
}
