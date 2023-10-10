<?php

namespace Database\Factories\Sid\Surat;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Surat\SidSuratKlasifikasi>
 */
class SidSuratKlasifikasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => Str::random(),
            'nama' => $this->faker->word,
            'uraian' => $this->faker->paragraph,
        ];
    }

    public function disabled()
    {
        return $this->state(fn () => ['enabled' => false]);
    }
}
