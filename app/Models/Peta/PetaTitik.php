<?php

namespace App\Models\Peta;

use App\Traits\Model\Relations\Peta\MorphToManyKategori;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaTitik extends Model
{
    use HasFactory;
    use MorphToManyKategori;
}
