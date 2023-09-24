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
            $table->foreignId('sid_surat_klasifikasi_id')->nullable();
            $table->foreignId('sid_pamong_id')->nullable();

            $table->string('pengirim');
            $table->string('perihal_surat');
            $table->string('isi_disposisi');

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
