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
        Schema::create('realisasis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('indikator_id')->constrained('indikators')->cascadeOnDelete();

            $table->year('tahun');

            $table->decimal('nilai_realisasi', 15, 2)->nullable();

            $table->enum('status_pencapaian', ['tercapai', 'belum_tercapai'])->nullable();

            $table->text('keterangan')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->unique(['indikator_id', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasis');
    }
};
