<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface BelongToManyPermissions
{
    public function permissions(): BelongsToMany;
}
