<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface BelongsToManyRoles
{
    public function roles(): BelongsToMany;
}
