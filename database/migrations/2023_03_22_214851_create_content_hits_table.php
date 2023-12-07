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
        Schema::create('content_hits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('content_id');
            $table->string('content_type');
            $table->text('payload');
        });

        Schema::create('content_model_has_hits', function (Blueprint $table) {
            $table->foreignId('hit_id');
            $table->foreignId('model_id');

            $table->string('model_type');

            $table->index(['model_id', 'model_type'], 'model_has_hits_model_id_model_type_index');

            $table->foreign('hit_id')
                ->references('id') // hit id
                ->on('content_hits')
                ->onDelete('cascade');

            $table->primary(['hit_id', 'model_id', 'model_type'],
                'model_has_hits_hit_model_type_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_hits');
        Schema::dropIfExists('content_model_has_hits');
    }
};
