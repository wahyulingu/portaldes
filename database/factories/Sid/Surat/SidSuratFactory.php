<?php

namespace Database\Factories\Sid\Surat;

use App\Models\Sid\Pamong\SidPamong;
use App\Models\Sid\Surat\SidSuratKeluar;
use App\Models\Sid\Surat\SidSuratMasuk;
use App\Models\Sid\Surat\SidSuratWarga;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Surat\SidSurat>
 */
class SidSuratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pamong_id' => SidPamong::factory(),
            'surat_id' => SidSuratMasuk::factory(),
            'surat_type' => SidSuratMasuk::class,
            'nomor_surat' => Str::random(),
            'tanggal' => now(),
        ];
    }

    public function suratKeluar()
    {
        return $this->state(fn () => [
            'surat_id' => SidSuratKeluar::factory(),
            'surat_type' => SidSuratKeluar::class,
        ]);
    }

    public function suratWarga()
    {
        return $this->state(fn () => [
            'surat_id' => SidSuratWarga::factory(),
            'surat_type' => SidSuratWarga::class,
        ]);
    }
}
