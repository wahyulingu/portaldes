<?php

namespace App\Enumerations;

use App\Traits\Enum\Finder;

enum OrderType
{
    use Finder;

    case generic;
    case include;
}
