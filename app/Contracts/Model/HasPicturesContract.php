<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface HasPicturesContract
{
    public function pictures(): MorphToMany;
}
