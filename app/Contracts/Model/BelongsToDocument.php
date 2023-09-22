<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface BelongsToDocument
{
    public function document(): BelongsTo;
}
