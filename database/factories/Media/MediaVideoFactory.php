<?php

namespace Database\Factories\Media;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media\MediaVideo>
 */
class MediaVideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(6, true),
            'description' => $this->faker->paragraph(),
        ];
    }
}
