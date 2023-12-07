<?php

namespace App\Models\Sid;

use App\Traits\Model\Relations\Media\BelongsToPicture;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidPhoto extends Model
{
    use BelongsToPicture;
    use HasFactory;

    protected $fillable = ['picture_id', 'sid_id', 'sid_type'];
}
