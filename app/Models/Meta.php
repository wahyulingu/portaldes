<?php

namespace App\Models;

use App\Traits\Model\Slug\SluggableByName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;
    use SluggableByName;

    protected $casts = ['value' => 'array'];

    protected $guarded = ['id'];
}
