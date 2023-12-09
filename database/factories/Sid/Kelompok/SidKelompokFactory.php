<?php

namespace Database\Factories\Sid\Kelompok;

use App\Models\Sid\Kelompok\SidKelompokKategori;
use App\Models\Sid\SidPenduduk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Kelompok\SidKelompok>
 */
class SidKelompokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kategori_id' => SidKelompokKategori::factory(),
            'ketua_id' => SidPenduduk::factory(),
            'nama' => $this->faker->words(2, true),
            'keterangan' => $this->faker->paragraph,
            'kode' => Str::random(10),
        ];
    }
}
