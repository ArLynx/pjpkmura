<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('indikators', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pilar_id')->constrained()->cascadeOnDelete();

            $table->string('tujuan_strategis');

            $table->string('nama_indikator');

            $table->string('instansi');

            $table->string('nilai_baseline')->nullable();

            $table->year('tahun_baseline')->nullable();

            $table->string('satuan')->nullable();

            $table->string('sumber_data')->nullable();

            $table->integer('urutan')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikators');
    }
};
