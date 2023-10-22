<?php

use App\Enumerations\Content\CategoryStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('status', CategoryStatus::values()->toArray())->default(CategoryStatus::active->name);
        });

        Schema::create('content_model_has_categories', function (Blueprint $table) {
            $table->foreignId('content_category_id');
            $table->foreignId('content_model_has_categories_id');

            $table->string('content_model_has_categories_type');

            $table->index(
                [
                    'content_model_has_categories_id',
                    'content_model_has_categories_type',
                ],

                'content_model_has_category_index'
            );

            $table->foreign('content_category_id')
                ->references('id') // category id
                ->on('content_categories')
                ->onDelete('cascade');

            $table->primary(
                [
                    'content_category_id',
                    'content_model_has_categories_id',
                    'content_model_has_categories_type',
                ],

                'content_model_has_category_primary'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_categories');
        Schema::dropIfExists('content_model_has_categories');
    }
};
