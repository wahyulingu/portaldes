<?php

namespace App\Enumerations;

use App\Traits\Enum\Finder;

enum Reaction
{
    use Finder;

    case like;
    case love;
    case care;
    case haha;
    case wow;
    case sad;
    case angry;
}
