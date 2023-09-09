<?php

namespace App\Enumerations;

use App\Traits\Enum\Finder;

enum Moderation
{
    use Finder;

    case pending;
    case draft;
    case accepted;
    case active;
    case closed;
    case rejected;
    case suspended;
    case blocked;
}
