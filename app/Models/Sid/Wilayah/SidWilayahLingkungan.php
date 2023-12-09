<?php

namespace App\Models\Sid\Wilayah;

use App\Models\Sid\SidPenduduk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class SidWilayahLingkungan extends Model
{
    use HasFactory;
    use HasRelationships;

    protected $guarded = ['id'];

    protected $table = 'sid_wilayah_lingkungan';

    public function rukunWarga(): HasMany
    {
        return $this->hasMany(SidWilayahRukunWarga::class);
    }

    public function rukunTetangga(): HasManyThrough
    {
        return $this->hasManyThrough(SidWilayahRukunTetangga::class, SidWilayahRukunWarga::class);
    }

    public function penduduk(): HasManyDeep
    {
        return $this->hasManyDeep(SidPenduduk::class, [SidWilayahRukunTetangga::class, SidWilayahRukunWarga::class]);
    }
}
