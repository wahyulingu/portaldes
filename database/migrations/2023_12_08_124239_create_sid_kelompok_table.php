<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sid_kelompok', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('kategori_id');
            $table->foreignId('ketua_id');

            $table->string('nama');
            $table->string('keterangan');
            $table->string('kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sid_kelompok');
    }
};
