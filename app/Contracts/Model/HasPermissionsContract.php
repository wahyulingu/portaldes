<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface HasPermissionsContract
{
    public function permissions(): BelongsToMany;
}
