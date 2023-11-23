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
        Schema::create('content_comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('content_id');
            $table->string('content_type');
            $table->enum('status', Moderation::values()->toArray())->default(Moderation::draft->name);
            $table->text('body');
        });

        Schema::create('content_model_has_comments', function (Blueprint $table) {
            $table->foreignId('content_comment_id');
            $table->foreignId('content_model_has_comments_id');

            $table->string('content_model_has_comments_type');

            $table->index(['content_model_has_comments_id', 'content_model_has_comments_type'], 'model_has_comments_model_id_model_type_index');

            $table->foreign('content_comment_id')
                ->references('id') // comment id
                ->on('content_comments')
                ->onDelete('cascade');

            $table->primary(['content_comment_id', 'content_model_has_comments_id', 'content_model_has_comments_type'],
                'model_has_comments_comment_model_type_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_comments');
        Schema::dropIfExists('content_model_has_comments');
    }
};
