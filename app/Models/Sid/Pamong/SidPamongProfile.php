<?php

namespace App\Models\Sid\Pamong;

use App\Traits\Model\Relations\Sid\MorphOneSidPhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidPamongProfile extends Model
{
    use HasFactory;
    use MorphOneSidPhoto;

    protected $guarded = ['id'];
    protected $table = 'sid_pamong_profile';
}
