<?php

namespace Database\Factories\Sid\Wilayah;

use App\Models\Sid\SidPenduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Wilayah\SidWilayahLingkungan>
 */
class SidWilayahLingkunganFactory extends Factory
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
            'nama' => $this->faker->streetName,
        ];
    }
}
