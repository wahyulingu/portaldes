<?php

namespace App\Enumerations\Medis;

use App\Traits\Enum\Finder;

enum GolonganDarah: string
{
    use Finder;

    case a = 'A';
    case b = 'B';
    case ab = 'AB';
    case o = 'O';
    case ap = 'A+';
    case am = 'A-';
    case bp = 'B+';
    case bm = 'B-';
    case abp = 'AB+';
    case abm = 'AB-';
    case op = 'O+';
    case om = 'O-';
    case m = '-';
}
