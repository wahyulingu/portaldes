<?php

namespace App\Repositories\Media;

use App\Abstractions\Repository\MediaRepository;
use App\Contracts\Model\HasPicture;
use App\Models\Media\MediaPicture;
use Illuminate\Database\Eloquent\Model;

class MediaPictureRepository extends MediaRepository
{
    public function create(Model&HasPicture $pictureable, array $attributes): MediaPicture
    {
        return $pictureable->picture()->create([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
        ]);
    }
}
