<?php

namespace App\Enumerations\Medis\Kelahiran;

use App\Traits\Enum\Finder;

enum Jenis: string
{
    use Finder;

    case tunggal = 'Tunggal';
    case kembar2 = 'Kembar 2';
    case kembar3 = 'Kembar 3';
    case kembar4 = 'Kembar 4';
}
