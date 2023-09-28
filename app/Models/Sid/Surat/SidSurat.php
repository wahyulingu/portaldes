<?php

namespace App\Models\Sid\Surat;

use App\Contracts\Model\BelongsToDocument;
use App\Traits\Model\Relations\Sid\BelongsToSidDocument;
use App\Traits\Model\Relations\Sid\BelongsToSidPamong;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SidSurat extends Model implements BelongsToDocument
{
    use HasFactory;
    use BelongsToSidDocument;
    use BelongsToSidPamong;

    protected $table = 'sid_surat';

    public function surat(): MorphTo
    {
        return $this->morphTo();
    }
}
