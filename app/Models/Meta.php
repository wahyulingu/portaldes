<?php

namespace App\Models;

use App\Contracts\Model\HasPictures;
use App\Traits\Model\Relations\Media\HasManyPictures;
use App\Traits\Model\Slug\SluggableByName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model implements HasPictures
{
    use HasFactory;
    use HasManyPictures;
    use SluggableByName;

    protected $casts = ['value' => 'array'];

    protected $guarded = ['id'];
}
