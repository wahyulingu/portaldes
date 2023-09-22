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
        Schema::create('sid_pamong', function (Blueprint $table) {
            $table->id();

            $table->decimal('nipd', 16, 0)->unique();
            $table->decimal('nik', 16, 0)->unique();

            $table->string('jabatan');
            $table->string('sk_pengangkatan')->nullable();
            $table->string('golongan')->nullable();
            $table->string('profile_type');

            $table->text('tupoksi')->nullable();

            $table->date('masa_jabatan')->nullable();
            $table->date('tgl_pengangkatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sid_pamong');
    }
};
