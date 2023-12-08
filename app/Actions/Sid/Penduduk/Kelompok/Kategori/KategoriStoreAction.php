<?php

namespace App\Actions\Sid\Penduduk\Kelompok;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Kategori;
use App\Enumerations\Medis;
use App\Enumerations\Pendidikan;
use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompokKategori;
use App\Repositories\Sid\Penduduk\Kelompok\SidPendudukKelompokKategoriRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidPendudukKelompokKategori>
 */
class KategoriStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected SidPendudukKelompokKategoriRepository $sidKategoriRepository)
    {
    }

    public function rules(array $payload): array
    {
        return [
            'nik' => ['required', 'string', 'regex:/^[0-9]{16}$/', Rule::unique(SidPendudukKelompokKategori::class)],
            'nomor_kartu_keluarga' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'nama' => 'required|string|max:32',
            'ktp' => ['required', Rule::enum(Kategori\Status\Ktp::class)],
            'hubungan_keluarga' => ['required', Rule::enum(Kategori\HubunganKeluarga::class)],
            'kelamin' => ['required', Rule::enum(Medis\JenisKelamin::class)],
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'status_kategori' => ['required', Rule::enum(Kategori\Status::class)],
            'agama' => ['required', Rule::enum(Kategori\Agama::class)],
            'pendidikan_kk' => ['required', Rule::enum(Pendidikan\Pendidikan::class)],
            'pekerjaan' => ['required', Rule::enum(Kategori\Pekerjaan::class)],
            'kewarganegaraan' => ['required', Rule::enum(Kategori\WargaNegara::class)],
            'status_kawin' => ['required', Rule::enum(Kategori\Status\Perkawinan::class)],
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
            'status_ktp' => ['nullable', Rule::enum(Kategori\Status\Ktp::class)],
            'waktu_lahir' => 'nullable',
            'tempat_dilahirkan' => ['nullable', Rule::enum(Medis\Kelahiran\Tempat::class)],
            'jenis_kelahiran' => ['nullable', Rule::enum(Medis\Kelahiran\Jenis::class)],
            'penolength_kelahiran' => ['nullable', Rule::enum(Medis\Kelahiran\Penolong::class)],
            'anak_ke' => 'nullable|numeric',
            'berat_lahir' => 'nullable|numeric',
            'panjang_lahir' => 'nullable|numeric',
            'tag_id_ktp' => 'nullable',
            'status_dasar' => ['nullable', Rule::enum(Kategori\Status\Dasar::class)],
            'foto' => 'nullable|file|image|max:2048',
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->sidKategoriRepository->store($validatedPayload);
    }
}
