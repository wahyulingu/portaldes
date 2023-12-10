<?php

namespace Database\Factories\Peta;

use App\Models\Media\MediaPicture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peta\PetaPicture>
 */
class PetaPictureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'picture_id' => MediaPicture::factory(),
            'nama' => $this->faker->word,
            'keterangan' => $this->faker->paragraph,
        ];
    }
}
