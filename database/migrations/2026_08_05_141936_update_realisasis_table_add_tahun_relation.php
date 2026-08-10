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
        Schema::table('realisasis', function (Blueprint $table) {
            // Tambah kolom tahun_id terlebih dahulu
            $table->unsignedBigInteger('tahun_id')->nullable()->after('indikator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('realisasis', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_id')->nullable()->after('indikator_id');

            $table->dropColumn('tahun');
        });
    }
};
