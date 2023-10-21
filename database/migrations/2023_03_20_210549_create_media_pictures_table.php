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
        Schema::create('media_pictures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pictureable_id');
            $table->timestamps();
            $table->string('pictureable_type');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_pictures');
    }
};
