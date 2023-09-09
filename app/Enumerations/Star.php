<?php

namespace App\Enumerations;

use App\Traits\Enum\Finder;

enum Star: int
{
    use Finder;

    case one = 1;
    case two = 2;
    case tree = 3;
    case four = 4;
    case five = 5;
}
