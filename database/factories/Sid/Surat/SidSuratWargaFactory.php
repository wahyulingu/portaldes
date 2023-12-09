<?php

namespace Database\Factories\Sid\Surat;

use App\Enumerations\Moderation;
use App\Models\Sid\SidPenduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Surat\SidSuratWarga>
 */
class SidSuratWargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'penduduk_id' => SidPenduduk::factory(),
            'short_desc' => $this->faker->paragraph,
            'payload' => [],
            'status' => Moderation::accepted,
        ];
    }
}
