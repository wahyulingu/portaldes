<?php

namespace Database\Factories\Media;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media\MediaPicture>
 */
class MediaPictureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mediable_id' => 0,
            'mediable_type' => static::class,
            'name' => $this->faker->words(6, true),
            'description' => $this->faker->paragraph(),
        ];
    }
}
