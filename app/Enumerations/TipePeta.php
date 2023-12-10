<?php

namespace App\Enumerations;

use App\Models\Peta\PetaArea;
use App\Models\Peta\PetaGaris;
use App\Models\Peta\PetaTitik;
use App\Traits\Enum\Finder;

enum TipePeta: string
{
    use Finder;

    case titik = PetaTitik::class;
    case garis = PetaGaris::class;
    case area = PetaArea::class;
}
