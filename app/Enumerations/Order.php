<?php

namespace App\Enumerations;

use App\Traits\Enum\Finder;

enum Order
{
    use Finder;

    case asc;
    case desc;
}
