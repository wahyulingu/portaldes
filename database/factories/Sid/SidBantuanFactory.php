<?php

namespace Database\Factories\Sid;

use App\Enumerations\SasaranBantuan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\SidPendudukBantuan>
 */
class SidBantuanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'awal' => $this->faker->date,
            'nama' => $this->faker->words(3, asText: true),
            'keterangan' => $this->faker->paragraph,
            'sasaran' => SasaranBantuan::values()->random(),
        ];
    }
}
