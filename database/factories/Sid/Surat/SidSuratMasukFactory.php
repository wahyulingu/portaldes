<?php

namespace Database\Factories\Sid\Surat;

use App\Models\Sid\Surat\SidSuratKlasifikasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Surat\SidSuratMasuk>
 */
class SidSuratMasukFactory extends Factory
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
            'pengirim' => $this->faker->company,
            'perihal' => $this->faker->paragraph,
            'disposisi' => $this->faker->paragraph,
            'tanggal_penerimaan' => now(),
        ];
    }
}
