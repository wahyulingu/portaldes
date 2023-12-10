<?php

namespace Database\Factories\Peta;

use App\Enumerations\TipePeta;
use App\Models\Peta\PetaSimbol;
use App\Models\Peta\PetaWarna;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peta\PetaKategori>
 */
class PetaKategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->words(asText: true),
            'tipe' => TipePeta::values()->random(),
            'keterangan' => $this->faker->paragraph,
            'warna_id' => PetaWarna::factory(),
            'simbol_id' => PetaSimbol::factory(),
        ];
    }

    public function titik()
    {
        return $this->state(['tipe' => TipePeta::titik->value]);
    }

    public function garis()
    {
        return $this->state(['tipe' => TipePeta::garis->value]);
    }

    public function area()
    {
        return $this->state(['tipe' => TipePeta::area->value]);
    }
}
