<?php

use App\Enumerations\SasaranBantuan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sid_bantuan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('awal');
            $table->date('akhir')->nullable();

            $table->string('nama');
            $table->string('keterangan');

            $table->enum('sasaran', SasaranBantuan::values()->toArray());
        });

        Schema::create('sid_model_has_sid_bantuan', function (Blueprint $table) {
            $table->foreignId('sid_bantuan_id');
            $table->foreignId('sid_model_has_sid_bantuan_id');

            $table->string('sid_model_has_sid_bantuan_type');

            $table->index(
                [
                    'sid_model_has_sid_bantuan_id',
                    'sid_model_has_sid_bantuan_type',
                ],

                'sid_model_has_sid_bantuan_index'
            );

            $table->foreign('sid_bantuan_id')
                ->references('id') // sid_bantuan id
                ->on('sid_bantuan')
                ->onDelete('cascade');

            $table->primary(
                [
                    'sid_bantuan_id',
                    'sid_model_has_sid_bantuan_id',
                    'sid_model_has_sid_bantuan_type',
                ],

                'sid_model_has_sid_bantuan_primary'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sid_bantuan');
        Schema::dropIfExists('sid_model_has_sid_bantuan');
    }
};
