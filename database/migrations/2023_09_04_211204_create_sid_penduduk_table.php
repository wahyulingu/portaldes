<?php

use App\Enumerations\Medis;
use App\Enumerations\Pendidikan;
use App\Enumerations\Penduduk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sid_penduduk', function (Blueprint $table) {
            $table->id();

            $table->foreignId('foto_id')->nullable();
            $table->foreignId('user_id')->nullable();

            $table->tinyInteger('anak_ke')->nullable();

            $table->string('nama');
            $table->string('dokumen_pasport')->nullable();
            $table->string('dokumen_kitas')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('akta_lahir')->nullable();
            $table->string('akta_perkawinan')->nullable();
            $table->string('akta_perceraian')->nullable();
            $table->string('telepon')->nullable();
            $table->string('berat_lahir')->nullable();
            $table->string('panjang_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tag_ktp')->nullable();
            $table->string('waktu_lahir')->nullable();

            $table->text('alamat_sebelumnya')->nullable();
            $table->text('alamat_sekarang')->nullable();

            $table->decimal('nik', 16, 0)->unique();
            $table->decimal('nomor_kartu_keluarga', 16, 0);
            $table->decimal('nomor_kartu_keluarga_sebelumnya', 16, 0)->nullable();
            $table->decimal('nik_ayah', 16, 0)->nullable();
            $table->decimal('nik_ibu', 16, 0)->nullable();

            $table->date('tanggal_lahir');
            $table->date('tanggal_akhir_paspor')->nullable();
            $table->date('tanggal_perkawinan')->nullable();
            $table->date('tanggal_perceraian')->nullable();

            $table->enum('hubungan_keluarga', Penduduk\HubunganKeluarga::values(asArray: true));
            $table->enum('kelamin', Medis\JenisKelamin::values(asArray: true));
            $table->enum('agama', Penduduk\Agama::values(asArray: true));
            $table->enum('pendidikan_kk', Pendidikan\Pendidikan::values(asArray: true));

            $table

                ->enum('status_penduduk', Penduduk\Status::values(asArray: true))
                ->nullable();

            $table

                ->enum('pendidikan_tempuh', Pendidikan\Tempuh::values(asArray: true))
                ->nullable();

            $table->enum('pekerjaan', Penduduk\Pekerjaan::values(asArray: true));
            $table->enum('status_kawin', Penduduk\Status\Perkawinan::values(asArray: true));

            $table->enum('kewarganegaraan', Penduduk\WargaNegara::values(asArray: true));

            $table

                ->enum('darah', Medis\GolonganDarah::values(asArray: true))
                ->nullable();

            $table

                ->enum('kb', Medis\Kontrasepsi::values(asArray: true))
                ->nullable();

            $table->enum('ktp', Penduduk\Status\Ktp::values(asArray: true));

            $table

                ->enum('status_ktp', Penduduk\Status\Ktp::values(asArray: true))
                ->nullable();

            $table

                ->enum('tempat_dilahirkan', Medis\Kelahiran\Tempat::values(asArray: true))
                ->nullable();

            $table

                ->enum('jenis_kelahiran', Medis\Kelahiran\Jenis::values(asArray: true))
                ->nullable();

            $table

                ->enum('penolong_kelahiran', Medis\Kelahiran\Penolong::values(asArray: true))
                ->nullable();

            $table

                ->enum('hamil', Medis\Kehamilan::values(asArray: true))
                ->nullable();

            $table

                ->enum('cacat', Medis\Cacat::values(asArray: true))
                ->nullable();

            $table

                ->enum('sakit', Medis\Penyakit::values(asArray: true))
                ->nullable();

            $table

                ->enum('status_dasar', Penduduk\Status\Dasar::values(asArray: true))
                ->default(Penduduk\Status\Dasar::hidup->value);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sid_penduduk');
    }
};
