<?php

namespace App\Models\Media;

use App\Traits\Model\HasRepository;
use App\Traits\Model\Relations\BelongsToUser;
use App\Traits\Model\Relations\MorphOneFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaVideo extends Model
{
    use HasFactory;
    use HasRepository;
    use BelongsToUser;
    use MorphOneFile;

    protected $fillable = ['name', 'description'];
}
