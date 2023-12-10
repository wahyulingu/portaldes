<?php

namespace Database\Factories\Peta;

use App\Models\Peta\PetaKategori;
use App\Models\Peta\PetaPicture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peta\PetaTitik>
 */
class PetaTitikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kategori_id' => PetaKategori::factory()->titik(),
            'picture_id' => PetaPicture::factory(),
            'nama' => $this->faker->word,
            'keterangan' => $this->faker->paragraph,
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
        ];
    }
}
