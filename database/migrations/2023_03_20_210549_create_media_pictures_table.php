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
            $table->timestamps();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description');
        });

        Schema::create('model_has_pictures', function (Blueprint $table) {
            $table->foreignId('media_picture_id');
            $table->foreignId('model_has_pictures_id');

            $table->string('model_has_pictures_type');

            $table->index(
                [
                    'model_has_pictures_id',
                    'model_has_pictures_type',
                ],

                'model_has_picture_index'
            );

            $table->foreign('media_picture_id')
                ->references('id') // picture id
                ->on('media_pictures')
                ->onDelete('cascade');

            $table->primary(
                [
                    'media_picture_id',
                    'model_has_pictures_id',
                    'model_has_pictures_type',
                ],

                'model_has_picture_primary'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_pictures');
        Schema::dropIfExists('model_has_pictures');
    }
};
