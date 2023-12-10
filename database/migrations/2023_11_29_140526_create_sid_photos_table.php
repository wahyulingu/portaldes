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
        Schema::create('sid_photos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('picture_id');
            $table->foreignId('sid_id');
            $table->string('sid_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sid_photos');
    }
};