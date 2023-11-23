<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface BelongsToPicture
{
    public function picture(): BelongsTo;
}
