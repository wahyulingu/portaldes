<?php

namespace App\Models\Peta;

use App\Traits\Model\Relations\Media\BelongsToPicture;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaGambar extends Model
{
    use HasFactory;
    use BelongsToPicture;

    protected $table = 'peta_picture';
}
