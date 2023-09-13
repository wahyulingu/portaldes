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

            $table->unsignedBigInteger('nipd');

            $table->foreignId('foto')->nullable();

            $table->string('telepon');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->string('email')->nullable();

            $table->enum('kelamin', JenisKelamin::values(asArray: true));
            $table->enum('pendidikan_kk', Pendidikan::values(asArray: true));
            $table->enum('agama', Agama::values(asArray: true));

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
