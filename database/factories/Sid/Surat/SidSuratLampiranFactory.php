<?php

namespace Database\Factories\Sid\Surat;

use App\Models\Sid\Surat\SidSurat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Surat\SidSuratLampiran>
 */
class SidSuratLampiranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'surat_id' => SidSurat::factory(),
            'description' => $this->faker->paragraph,
        ];
    }
}
