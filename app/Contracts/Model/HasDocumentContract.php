<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasDocumentContract
{
    public function document(): BelongsTo;
}
