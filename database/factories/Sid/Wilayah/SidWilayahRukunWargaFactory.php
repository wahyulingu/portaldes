<?php

namespace Database\Factories\Sid\Wilayah;

use App\Models\Sid\SidPenduduk;
use App\Models\Sid\Wilayah\SidWilayahLingkungan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Wilayah\SidWilayahRukunWarga>
 */
class SidWilayahRukunWargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ketua_id' => SidPenduduk::factory(),
            'lingkungan_id' => SidWilayahLingkungan::factory(),
            'nama' => Str::padLeft(mt_rand(1, 8), 3, '0'),
        ];
    }
}
