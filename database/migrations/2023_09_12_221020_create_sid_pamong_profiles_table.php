<?php

use App\Enumerations\Medis\JenisKelamin;
use App\Enumerations\Pendidikan\Pendidikan;
use App\Enumerations\Penduduk\Agama;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sid_pamong_profile', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nipd');

            $table->foreignId('foto_id')->nullable();

            $table->string('telepon');
            $table->string('alamat_sekarang');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->string('email')->nullable();

            $table->enum('kelamin', JenisKelamin::values()->toArray());
            $table->enum('pendidikan_kk', Pendidikan::values()->toArray());
            $table->enum('agama', Agama::values()->toArray());

            $table->date('tgl_lahir');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sid_pamong_profile');
    }
};
