<?php

namespace Database\Factories\Sid\Surat;

use App\Models\Sid\Surat\SidSuratKlasifikasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Surat\SidSuratKeluar>
 */
class SidSuratKeluarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'klasifikasi_id' => SidSuratKlasifikasi::factory(),
            'tujuan' => $this->faker->company,
            'short_desc' => $this->faker->paragraph,
        ];
    }
}
