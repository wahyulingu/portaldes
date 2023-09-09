<?php

use App\Enumerations\Penduduk\Status\Sosial;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sid_keluarga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rukun_tetangga_id');

            $table->decimal('no_kk', 16, 0)->unique();

            $table->text('alamat');

            $table->enum('sosial', Sosial::values(asArray: true));

            $table->dateTime('tgl_cetak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sid_keluarga');
    }
};
