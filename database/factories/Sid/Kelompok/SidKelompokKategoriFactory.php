<?php

namespace Database\Factories\Sid\Kelompok;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Kelompok\SidKelompokKategori>
 */
class SidKelompokKategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->words(2, true),
            'keterangan' => $this->faker->paragraph,
        ];
    }
}
