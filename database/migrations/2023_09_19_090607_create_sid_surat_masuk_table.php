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
        Schema::create('sid_surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klasifikasi_id')->nullable();

            $table->string('pengirim');
            $table->string('perihal');
            $table->string('disposisi');

            $table->date('tanggal_penerimaan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sid_surat_masuk');
    }
};
