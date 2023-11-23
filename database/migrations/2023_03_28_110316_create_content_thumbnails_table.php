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
        Schema::create('content_thumbnails', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('picture_id');
            $table->foreignId('content_id');
            $table->string('content_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_thumbnails');
    }
};
