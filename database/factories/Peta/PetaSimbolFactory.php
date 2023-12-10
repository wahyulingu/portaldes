<?php

namespace Database\Factories\Peta;

use App\Models\Peta\PetaPicture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peta\PetaSimbol>
 */
class PetaSimbolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word,
            'picture_id' => PetaPicture::factory(),
        ];
    }
}
