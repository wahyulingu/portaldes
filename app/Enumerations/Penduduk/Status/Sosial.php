<?php

namespace App\Enumerations\Penduduk\Status;

use App\Traits\Enum\Finder;

enum Sosial: string
{
    use Finder;

    case kps = 'Keluarga Pra Sejahtera';
    case ks1 = 'Keluarga Sejahtera I';
    case ks2 = 'Keluarga Sejahtera II';
    case ks3 = 'Keluarga Sejahtera III';
    case ksp = 'Keluarga Sejahtera III Plus';
}
