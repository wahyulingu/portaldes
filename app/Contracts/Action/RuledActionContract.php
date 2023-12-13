<?php

namespace App\Contracts\Action;

use Illuminate\Support\Collection;

interface RuledActionContract
{
    public function rules(Collection $payload): array;
}
