<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface HasSuratContract
{
    public function surat(): MorphOne;
}
