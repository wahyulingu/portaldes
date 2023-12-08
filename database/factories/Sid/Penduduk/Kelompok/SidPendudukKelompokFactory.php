<?php

namespace Database\Factories\Sid\Penduduk\Kelompok;

use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompokKategori;
use App\Models\Sid\Penduduk\SidPenduduk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompok>
 */
class SidPendudukKelompokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kategori_id' => SidPendudukKelompokKategori::factory(),
            'ketua_id' => SidPenduduk::factory(),
            'nama' => $this->faker->words(2, true),
            'keterangan' => $this->faker->paragraph,
            'kode' => Str::random(10),
        ];
    }
}
