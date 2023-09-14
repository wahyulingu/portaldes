<?php

namespace Database\Factories\Sid\Pamong;

use App\Enumerations\Medis\JenisKelamin;
use App\Enumerations\Pendidikan\Pendidikan;
use App\Enumerations\Penduduk\Agama;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\Pamong\SidPamongProfile>
 */
class SidPamongProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nipd' => mt_rand(1000000, 9999999),
            'telepon' => $this->faker->phoneNumber,
            'alamat_sekarang' => $this->faker->address,
            'nama' => $this->faker->name,
            'tempat_lahir' => $this->faker->city,
            'email' => $this->faker->email,
            'kelamin' => JenisKelamin::random(),
            'pendidikan_kk' => Pendidikan::random(),
            'agama' => Agama::random(),
            'tgl_lahir' => $this->faker->date,
        ];
    }
}
