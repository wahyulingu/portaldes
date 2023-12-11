<?php

namespace App\Actions\Sid\Penduduk;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Medis;
use App\Enumerations\Pendidikan;
use App\Enumerations\Penduduk;
use App\Models\Sid\SidPenduduk;
use App\Repositories\Sid\SidPendudukRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidPenduduk>
 */
class PendudukStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected SidPendudukRepository $sidPendudukRepository)
    {
    }

    public function rules(Collection $payload): array
    {
        return [
            'nik' => ['required', 'string', 'regex:/^[0-9]{16}$/', Rule::unique(SidPenduduk::class)],
            'nomor_kartu_keluarga' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'nama' => 'required|string|max:32',
            'ktp' => ['required', Rule::enum(Penduduk\Status\Ktp::class)],
            'hubungan_keluarga' => ['required', Rule::enum(Penduduk\HubunganKeluarga::class)],
            'kelamin' => ['required', Rule::enum(Medis\JenisKelamin::class)],
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'status_penduduk' => ['required', Rule::enum(Penduduk\Status::class)],
            'agama' => ['required', Rule::enum(Penduduk\Agama::class)],
            'pendidikan_kk' => ['required', Rule::enum(Pendidikan\Pendidikan::class)],
            'pekerjaan' => ['required', Rule::enum(Penduduk\Pekerjaan::class)],
            'kewarganegaraan' => ['required', Rule::enum(Penduduk\WargaNegara::class)],
            'status_kawin' => ['required', Rule::enum(Penduduk\Status\Perkawinan::class)],
            'nomor_kartu_keluarga' => 'nullable|string|size:16',
            'nomor_kartu_keluarga_sebelumnya' => 'nullable|string|size:16',
            'pendidikan_tempuh' => ['nullable', Rule::enum(Pendidikan\Tempuh::class)],
            'dokumen_pasport' => 'nullable',
            'tanggal_akhir_paspor' => 'nullable',
            'dokumen_kitas' => 'nullable',
            'nik_ayah' => 'nullable|string|regex:/^[0-9]{16}$/',
            'nama_ayah' => 'nullable|max:32',
            'nik_ibu' => 'nullable|string|regex:/^[0-9]{16}$/',
            'nama_ibu' => 'nullable|string|size:32',
            'darah' => ['nullable', Rule::enum(Medis\GolonganDarah::class)],
            'hamil' => ['nullable', Rule::enum(Medis\Kehamilan::class)],
            'cacat' => ['nullable', Rule::enum(Medis\Cacat::class)],
            'sakit' => 'nullable|string',
            'akta_lahir' => 'nullable',
            'akta_perkawinan' => 'nullable',
            'tanggal_perkawinan' => 'nullable',
            'akta_perceraian' => 'nullable',
            'tanggal_perceraian' => 'nullable',
            'kb' => ['nullable', Rule::enum(Medis\Kontrasepsi::class)],
            'telepon' => 'nullable',
            'alamat_sebelumnya' => 'nullable',
            'alamat_sekarang' => 'nullable',
            'status_ktp' => ['nullable', Rule::enum(Penduduk\Status\Ktp::class)],
            'waktu_lahir' => 'nullable',
            'tempat_dilahirkan' => ['nullable', Rule::enum(Medis\Kelahiran\Tempat::class)],
            'jenis_kelahiran' => ['nullable', Rule::enum(Medis\Kelahiran\Jenis::class)],
            'penolength_kelahiran' => ['nullable', Rule::enum(Medis\Kelahiran\Penolong::class)],
            'anak_ke' => 'nullable|numeric',
            'berat_lahir' => 'nullable|numeric',
            'panjang_lahir' => 'nullable|numeric',
            'tag_id_ktp' => 'nullable',
            'status_dasar' => ['nullable', Rule::enum(Penduduk\Status\Dasar::class)],
            'foto' => 'nullable|file|image|max:2048',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->sidPendudukRepository->store($validatedPayload);
    }
}
