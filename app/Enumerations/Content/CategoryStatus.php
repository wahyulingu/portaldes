<?php

namespace App\Enumerations\Content;

use App\Traits\Enum\Finder;

enum CategoryStatus: string
{
    use Finder;

    case active = 'active';
    case closed = 'closed';
    case hiden = 'hiden';
}
