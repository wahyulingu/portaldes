<?php

namespace Database\Factories\Sid;

use App\Enumerations\Medis\Cacat;
use App\Enumerations\Medis\GolonganDarah;
use App\Enumerations\Medis\JenisKelamin;
use App\Enumerations\Medis\Kehamilan;
use App\Enumerations\Medis\Kelahiran\Jenis;
use App\Enumerations\Medis\Kelahiran\Penolong;
use App\Enumerations\Medis\Kelahiran\Tempat;
use App\Enumerations\Medis\Kontrasepsi;
use App\Enumerations\Medis\Penyakit;
use App\Enumerations\Pendidikan\Pendidikan;
use App\Enumerations\Pendidikan\Tempuh;
use App\Enumerations\Penduduk\Agama;
use App\Enumerations\Penduduk\HubunganKeluarga;
use App\Enumerations\Penduduk\Pekerjaan;
use App\Enumerations\Penduduk\Status;
use App\Enumerations\Penduduk\Status\Dasar;
use App\Enumerations\Penduduk\Status\Ktp;
use App\Enumerations\Penduduk\Status\Perkawinan;
use App\Enumerations\Penduduk\WargaNegara;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sid\SidPenduduk>
 */
class SidPendudukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'anak_ke' => mt_rand(1, 4),
            'nama' => $this->faker->name,
            'nama_ayah' => $this->faker->name('man'),
            'nama_ibu' => $this->faker->name('woman'),
            'telepon' => $this->faker->phoneNumber,
            'berat_lahir' => 4,
            'panjang_lahir' => 35,
            'waktu_lahir' => $this->faker->time,
            'alamat_sebelumnya' => $this->faker->address,
            'alamat_sekarang' => $this->faker->address,
            'nik' => mt_rand(1000000000000000, 9999999999999999),
            'nomor_kartu_keluarga' => mt_rand(1000000000000000, 9999999999999999),
            'nomor_kartu_keluarga_sebelumnya' => mt_rand(1000000000000000, 9999999999999999),
            'nik_ayah' => mt_rand(1000000000000000, 9999999999999999),
            'nik_ibu' => mt_rand(1000000000000000, 9999999999999999),
            'tanggal_lahir' => $this->faker->date,
            'tempat_lahir' => $this->faker->city,
            'hubungan_keluarga' => HubunganKeluarga::random(),
            'kelamin' => JenisKelamin::random(),
            'agama' => Agama::random(),
            'pendidikan_kk' => Pendidikan::random(),
            'status_penduduk' => Status::random(),
            'pendidikan_tempuh' => Tempuh::random(),
            'pekerjaan' => Pekerjaan::random(),
            'status_kawin' => Perkawinan::random(),
            'kewarganegaraan' => WargaNegara::random(),
            'darah' => GolonganDarah::random(),
            'kb' => Kontrasepsi::random(),
            'ktp' => Ktp::random(),
            'status_ktp' => Ktp::random(),
            'tempat_dilahirkan' => Tempat::random(),
            'jenis_kelahiran' => Jenis::random(),
            'penolong_kelahiran' => Penolong::random(),
            'hamil' => Kehamilan::random(),
            'cacat' => Cacat::random(),
            'sakit' => Penyakit::random(),
            'status_dasar' => Dasar::random(),
        ];
    }
}
