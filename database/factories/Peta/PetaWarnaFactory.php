<?php

namespace Database\Factories\Peta;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peta\PetaWarna>
 */
class PetaWarnaFactory extends Factory
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
            'kode' => '#'.rand(111111, 999999),
            'keterangan' => $this->faker->paragraph,
        ];
    }
}
