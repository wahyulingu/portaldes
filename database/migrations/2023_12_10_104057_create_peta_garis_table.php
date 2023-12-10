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
        Schema::create('peta_garis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('kategori_id');
            $table->foreignId('picture_id');

            $table->string('nama');
            $table->string('keterangan');
            $table->polygon('path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peta_garis');
    }
};
