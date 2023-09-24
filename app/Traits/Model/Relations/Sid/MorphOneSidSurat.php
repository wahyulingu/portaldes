<?php

namespace App\Traits\Model\Relations\Sid;

use App\Models\Sid\Surat\SidSurat;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphOneSidSurat
{
    public function surat(): MorphOne
    {
        return $this->morphOne(SidSurat::class, 'surat');
    }
}
