<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasPictureContract
{
    public function picture(): BelongsTo;
}
