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
        Schema::create('sid_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sid_document_id');
            $table->foreignId('surat_id');

            $table->string('surat_type');
            $table->string('nomor_urut')->nullable();
            $table->string('nomor_surat');

            $table->date('tanggal_surat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sid_surat');
    }
};
