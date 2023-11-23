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
        Schema::create('content_articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->foreignId('category_id')->nullable();
            $table->enum('status', Moderation::names()->toArray())->default(Moderation::draft->name);
            $table->string('slug');
            $table->string('title');
            $table->text('body');
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_articles');
    }
};
