<?php

namespace App\Enumerations;

use App\Traits\Enum\Finder;

enum Payment
{
    use Finder;

    case required;
    case paid;
    case accepted;
    case late;
    case canceled;
    case refunding;
    case refunded;
    case rejected;
}
