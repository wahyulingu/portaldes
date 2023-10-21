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
        Schema::create('media_videos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description');
        });

        Schema::create('model_has_videos', function (Blueprint $table) {
            $table->foreignId('media_video_id');
            $table->foreignId('model_has_videos_id');

            $table->string('model_has_videos_type');

            $table->index(
                [
                    'model_has_videos_id',
                    'model_has_videos_type',
                ],

                'model_has_video_index'
            );

            $table->foreign('media_video_id')
                ->references('id') // video id
                ->on('media_videos')
                ->onDelete('cascade');

            $table->primary(
                [
                    'media_video_id',
                    'model_has_videos_id',
                    'model_has_videos_type',
                ],

                'model_has_video_primary'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_videos');
        Schema::dropIfExists('model_has_videos');
    }
};
