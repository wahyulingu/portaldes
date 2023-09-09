<?php

namespace App\Enumerations\Medis;

use App\Traits\Enum\Finder;

enum Penyakit: string
{
    use Finder;

    case jantung = 'Jantung';
    case lever = 'Lever';
    case paru = 'Paru-Paru';
    case kanker = 'Kanker';
    case stroke = 'Stroke';
    case diabetes = 'Diabetes Militus';
    case ginjal = 'Ginjal';
    case malaria = 'Malaria';
    case kusta = 'Lepra/Kusta';
    case aids = 'HIV/AIDS';
    case gila = 'Gila/Stress';
    case tbc = 'TBC';
    case asthma = 'Asthma';
    case tidak = 'Tidak Sakit';
}
