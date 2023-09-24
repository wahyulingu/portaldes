<?php

namespace Database\Factories\Sid;

use App\Enumerations\Penduduk\Status\Sosial;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\SidKeluarga>
 */
class SidKeluargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rukun_tetangga_id' => SidWilayahRukunTetangga::factory(),
            'nomor_kartu_keluarga' => mt_rand(1000000000000000, 9999999999999999),
            'alamat' => $this->faker->address,
            'sosial' => Sosial::random(),
        ];
    }
}
