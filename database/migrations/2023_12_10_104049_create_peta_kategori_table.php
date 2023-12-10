<?php

use App\Enumerations\TipePeta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peta_kategori', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('simbol_id')->nullable();
            $table->foreignId('warna_id')->nullable();

            $table->string('nama');
            $table->string('keterangan')->nullable();

            $table->enum('tipe', TipePeta::values()->toArray());
        });

        Schema::create('peta_model_has_kategori', function (Blueprint $table) {
            $table->foreignId('peta_kategori_id');
            $table->foreignId('peta_model_has_kategori_id');

            $table->string('peta_model_has_kategori_type');

            $table->index(
                [
                    'peta_model_has_kategori_id',
                    'peta_model_has_kategori_type',
                ],

                'peta_model_has_kategori_index'
            );

            $table->foreign('peta_kategori_id')
                ->references('id') // kategori id
                ->on('peta_kategori')
                ->onDelete('cascade');

            $table->primary(
                [
                    'peta_kategori_id',
                    'peta_model_has_kategori_id',
                    'peta_model_has_kategori_type',
                ],

                'peta_model_has_kategori_primary'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peta_kategori');
        Schema::dropIfExists('peta_model_has_kategori');
    }
};
