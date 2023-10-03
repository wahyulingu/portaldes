<?php

use App\Enumerations\Moderation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sid_surat_warga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id');

            $table->json('payload');

            $table->enum('status', Moderation::values()->toArray());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sid_surat_warga');
    }
};
