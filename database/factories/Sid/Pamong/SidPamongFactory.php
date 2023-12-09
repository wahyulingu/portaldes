<?php

namespace Database\Factories\Sid\Pamong;

use App\Models\Sid\Pamong\SidPamongProfile;
use App\Models\Sid\SidPenduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Pamong\SidPamong>
 */
class SidPamongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nipd' => SidPamongProfile::factory(),
            'nik' => SidPenduduk::factory(),
            'jabatan' => $this->faker->word,
            'golongan' => $this->faker->word,
            'tupoksi' => $this->faker->word,
            'tgl_pengangkatan' => $this->faker->date,
            'profile_type' => SidPamongProfile::class,
        ];
    }

    public function fromPenduduk()
    {
        return $this->state(fn () => [
            'profile_type' => SidPenduduk::class,
        ]);
    }
}
