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
        Schema::create('content_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->foreignId('content_id');
            $table->string('content_type');
            $table->enum('status', Moderation::values()->toArray())->default(Moderation::draft->name);
            $table->json('data');
        });

        Schema::create('content_model_has_histories', function (Blueprint $table) {
            $table->foreignId('history_id');
            $table->foreignId('model_id');

            $table->string('model_type');

            $table->index(['model_id', 'model_type'], 'model_has_histories_model_id_model_type_index');

            $table->foreign('history_id')
                ->references('id') // history id
                ->on('content_histories')
                ->onDelete('cascade');

            $table->primary(['history_id', 'model_id', 'model_type'],
                'model_has_histories_history_model_type_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_histories');
        Schema::dropIfExists('content_model_has_histories');
    }
};
