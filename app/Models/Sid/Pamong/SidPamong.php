<?php

namespace App\Models\Sid\Pamong;

use App\Models\Sid\SidPenduduk;
use App\Traits\Model\HasRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SidPamong extends Model
{
    use HasFactory;
    use HasRepository;

    protected $guarded = ['id'];

    protected $table = 'sid_pamong';

    public function profile(): MorphTo
    {
        if (SidPenduduk::class == $this->profile_type) {
            return $this->morphTo(id: 'nik');
        }

        return $this->morphTo(id: 'nipd');
    }
}
