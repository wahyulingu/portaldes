<?php

namespace App\Models\Sid\Pamong;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidPamongProfile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'sid_pamong_profile';
}
