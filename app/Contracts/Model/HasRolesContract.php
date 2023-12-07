<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface HasRolesContract
{
    public function roles(): BelongsToMany;
}
