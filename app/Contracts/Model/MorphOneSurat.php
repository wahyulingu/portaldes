<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface MorphOneSurat
{
    public function surat(): MorphOne;
}
