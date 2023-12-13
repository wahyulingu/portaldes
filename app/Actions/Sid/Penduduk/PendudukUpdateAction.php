<?php

namespace App\Actions\Sid\Penduduk;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Medis;
use App\Enumerations\Pendidikan;
use App\Enumerations\Penduduk;
use App\Models\Sid\SidPenduduk;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidPenduduk>
 */
class PendudukUpdateAction extends Action implements RuledActionContract
{
    protected SidPenduduk $penduduk;

    public function prepare(SidPenduduk $penduduk)
    {
        return tap($this, fn (self $action) => $action->penduduk = $penduduk);
    }

    public function rules(Collection $payload): array
    {
        return [
            'nik' => ['sometimes', 'string', 'regex:/^[0-9]{16}$/', Rule::unique(SidPenduduk::class)],
            'nomor_kartu_keluarga' => ['sometimes', 'string', 'regex:/^[0-9]{16}$/'],
            'nama' => 'sometimes|string|max:32',
            'ktp' => ['sometimes', Rule::enum(Penduduk\Status\Ktp::class)],
            'hubungan_keluarga' => ['sometimes', Rule::enum(Penduduk\HubunganKeluarga::class)],
            'kelamin' => ['sometimes', Rule::enum(Medis\JenisKelamin::class)],
            'tempat_lahir' => 'sometimes|string',
            'tanggal_lahir' => 'sometimes|string',
            'status_penduduk' => ['sometimes', Rule::enum(Penduduk\Status::class)],
            'agama' => ['sometimes', Rule::enum(Penduduk\Agama::class)],
            'pendidikan_kk' => ['sometimes', Rule::enum(Pendidikan\Pendidikan::class)],
            'pekerjaan' => ['sometimes', Rule::enum(Penduduk\Pekerjaan::class)],
            'kewarganegaraan' => ['sometimes', Rule::enum(Penduduk\WargaNegara::class)],
            'status_kawin' => ['sometimes', Rule::enum(Penduduk\Status\Perkawinan::class)],
            'nomor_kartu_keluarga' => 'sometimes|string|size:16',
            'nomor_kartu_keluarga_sebelumnya' => 'sometimes|string|size:16',
            'pendidikan_tempuh' => ['sometimes', Rule::enum(Pendidikan\Tempuh::class)],
            'dokumen_pasport' => 'sometimes',
            'tanggal_akhir_paspor' => 'sometimes',
            'dokumen_kitas' => 'sometimes',
            'nik_ayah' => 'sometimes|string|regex:/^[0-9]{16}$/',
            'nama_ayah' => 'sometimes|max:32',
            'nik_ibu' => 'sometimes|string|regex:/^[0-9]{16}$/',
            'nama_ibu' => 'sometimes|string|size:32',
            'darah' => ['sometimes', Rule::enum(Medis\GolonganDarah::class)],
            'hamil' => ['sometimes', Rule::enum(Medis\Kehamilan::class)],
            'cacat' => ['sometimes', Rule::enum(Medis\Cacat::class)],
            'sakit' => 'sometimes|string',
            'akta_lahir' => 'sometimes',
            'akta_perkawinan' => 'sometimes',
            'tanggal_perkawinan' => 'sometimes',
            'akta_perceraian' => 'sometimes',
            'tanggal_perceraian' => 'sometimes',
            'kb' => ['sometimes', Rule::enum(Medis\Kontrasepsi::class)],
            'telepon' => 'sometimes',
            'alamat_sebelumnya' => 'sometimes',
            'alamat_sekarang' => 'sometimes',
            'status_ktp' => ['sometimes', Rule::enum(Penduduk\Status\Ktp::class)],
            'waktu_lahir' => 'sometimes',
            'tempat_dilahirkan' => ['sometimes', Rule::enum(Medis\Kelahiran\Tempat::class)],
            'jenis_kelahiran' => ['sometimes', Rule::enum(Medis\Kelahiran\Jenis::class)],
            'penolength_kelahiran' => ['sometimes', Rule::enum(Medis\Kelahiran\Penolong::class)],
            'anak_ke' => 'sometimes|numeric',
            'berat_lahir' => 'sometimes|numeric',
            'panjang_lahir' => 'sometimes|numeric',
            'tag_id_ktp' => 'sometimes',
            'status_dasar' => ['sometimes', Rule::enum(Penduduk\Status\Dasar::class)],
            'foto' => 'sometimes|file|image|max:2048',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->penduduk->update($validatedPayload->toArray());
    }
}
