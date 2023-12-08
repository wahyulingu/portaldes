<?php

namespace App\Repositories\Sid;

use App\Abstractions\Repository\SidRepository;
use App\Contracts\Model\HasPhotoContract;
use App\Models\Sid\SidPhoto;
use Illuminate\Database\Eloquent\Model;

class SidPhotoRepository extends SidRepository
{
    public function create(Model&HasPhotoContract $content): SidPhoto
    {
        return $content->photo()->create();
    }
}
