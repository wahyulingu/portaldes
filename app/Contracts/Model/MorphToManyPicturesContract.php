<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface MorphToManyPicturesContract
{
    public function pictures(): MorphToMany;
}
