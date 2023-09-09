<?php

namespace App\Enumerations\Medis;

use App\Traits\Enum\Finder;

enum Kehamilan: string
{
    use Finder;

    case hamil = 'Hamil';
    case tidak = 'Tidak Hamil';
}
