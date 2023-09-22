<?php

namespace App\Models\Sid;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SidDocument extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'sid_document';

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
