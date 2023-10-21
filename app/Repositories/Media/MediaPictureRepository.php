<?php

namespace App\Repositories\Media;

use App\Abstractions\Repository\MediaRepository;
use App\Models\Media\MediaPicture;
use Illuminate\Database\Eloquent\Model;

class MediaPictureRepository extends MediaRepository
{
    public function create(Model $pictureable, array $attributes): MediaPicture
    {
        return $this->store([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'pictureable_type' => $pictureable::class,
            'pictureable_id' => $pictureable->getKey(),
        ]);
    }
}
