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
        Schema::create('peta_simbol', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('picture_id');
            $table->string('nama');
        });
    }

    /**
     * Reverse the migrations.lat.
     */
    public function down(): void
    {
        Schema::dropIfExists('peta_simbol');
    }
};
