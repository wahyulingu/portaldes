<?php

namespace App\Models\Media;

use App\Traits\Model\HasRepository;
use App\Traits\Model\Relations\MorphOneFile;
use App\Traits\Model\Slug\SluggableByName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaVideo extends Model
{
    use HasFactory;
    use HasRepository;
    use SluggableByName;
    use MorphOneFile;

    protected $fillable = ['name', 'description'];
}
